<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Validator;
use App\Models\FileUpload;

class FileUploadController extends Controller
{
    // ===== Helpers ===========================================================
    // Helper to strip BOM and ensure UTF-8 text
    private function stripBomToUtf8(string $s): string
    {
        // UTF-8 BOM
        if (strncmp($s, "\xEF\xBB\xBF", 3) === 0) return substr($s, 3);
        // UTF-32 LE BOM
        if (strncmp($s, "\xFF\xFE\x00\x00", 4) === 0) return mb_convert_encoding(substr($s, 4), 'UTF-8', 'UTF-32LE');
        // UTF-32 BE BOM
        if (strncmp($s, "\x00\x00\xFE\xFF", 4) === 0) return mb_convert_encoding(substr($s, 4), 'UTF-8', 'UTF-32BE');
        // UTF-16 LE BOM
        if (strncmp($s, "\xFF\xFE", 2) === 0) return mb_convert_encoding(substr($s, 2), 'UTF-8', 'UTF-16LE');
        // UTF-16 BE BOM
        if (strncmp($s, "\xFE\xFF", 2) === 0) return mb_convert_encoding(substr($s, 2), 'UTF-8', 'UTF-16BE');
        // No BOM — try to ensure it's UTF-8 (optional safety net)
        return mb_convert_encoding($s, 'UTF-8', 'UTF-8');
    }

    private function safeDecodeJson(string $raw): array
    {
        // 1) Strip/normalize
        $clean = $this->stripBomToUtf8($raw);

        // 2) First attempt
        $decoded = json_decode($clean, true);
        if ($decoded !== null || json_last_error() === JSON_ERROR_NONE) {
            return [$clean, $decoded];
        }

        // 3) Fallback: try broader transcode (handles some odd encodings)
        $fallback  = mb_convert_encoding($clean, 'UTF-8', 'UTF-8, UTF-16LE, UTF-16BE, UTF-32LE, UTF-32BE, ISO-8859-1, Windows-1252');
        $decoded2  = json_decode($fallback, true);
        return [$fallback, $decoded2];
    }

    // Build simple chart metadata from first feature’s properties
    private function buildPropsMetadata(?array $json): array
    {
        $meta = ['x_axis' => [], 'y_axis' => []];
        if (!is_array($json)) return $meta;
        if (($json['type'] ?? '') !== 'FeatureCollection') return $meta;

        $props = $json['features'][0]['properties'] ?? null;
        if (!is_array($props)) return $meta;

        foreach ($props as $k => $v) {
            $meta['x_axis'][] = $k;
            if (is_numeric($v)) $meta['y_axis'][] = $k;
        }
        return $meta;
    }

    // Save a normalized GeoJSON text into FileUpload
    private function storeGeojsonUpload(
        int $userId,
        string $storagePath,         // e.g., "users/123"
        string $filename,            // e.g., "foo.geojson"
        string $geojsonText,         // normalized UTF-8 JSON string
        ?array $decoded,             // decoded JSON array (for metadata)
        string $md5OfSource,
        string $title
    ): void {
        $file_upload                       = new FileUpload;
        $file_upload->user_id              = $userId;
        $file_upload->filename             = $filename;
        $file_upload->geojson              = $geojsonText;
        $file_upload->properties_metadata  = json_encode($this->buildPropsMetadata($decoded));
        $file_upload->md5                  = $md5OfSource;
        $file_upload->title                = $title;
        $file_upload->save();
    }

    // ===== Main upload =======================================================
    public function upload(Request $request)
    {
        // Custom validator so we can also set a popup-friendly session('error')
        $validator = Validator::make(
            $request->all(),
            [
                'my_file' => ['required'],
                'title'   => ['required'],
            ],
            [
                'my_file.required' => 'Please choose a file to upload.',
                'title.required'   => 'Please give the file a name.',
            ]
        );

        if ($validator->fails()) {
            // Send back both the normal error bag AND a toast-friendly message.
            return back()
                ->withErrors($validator)
                ->with('error', $validator->errors()->first())
                ->withInput();
        }

        $file    = $request->file('my_file');
        $title   = $request->title;
        $userId  = auth()->id(); // Assuming authenticated user
        $path    = "users/{$userId}";

        // Sanitize filename (keep it simple)
        $filename        = preg_replace('/[^A-Za-z0-9_.]/', '', basename($file->getClientOriginalName()));
        $file_extension  = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $filename_only   = pathinfo($filename, PATHINFO_FILENAME);

        // Duplicate check
        if (FileUpload::where('filename', '=', $filename)->where('user_id', '=', $userId)->exists()) {
            return back()->with('error', 'This file already exists within the system')->withInput();
        }

        // Save original upload (so we can work with it on disk)
        if (!Storage::putFileAs($path, $file, $filename)) {
            return back()->with('error', 'We were unable to save the file to the system. Please try again')->withInput();
        }

        $filePath = storage_path("app/$path/$filename"); // absolute path (for ogr tools)
        $md5      = md5_file($filePath) ?: '';

        // --- Handle by extension ------------------------------------------------
        if ($file_extension === 'geojson') {
            // Read & normalize
            $raw = Storage::get("$path/$filename");
            [$clean, $json] = $this->safeDecodeJson($raw);

            if (!is_array($json) || ($json['type'] ?? '') !== 'FeatureCollection') {
                return back()->with('error', 'Invalid or unreadable GeoJSON (must be a FeatureCollection).');
            }

            $this->storeGeojsonUpload($userId, $path, $filename, $clean, $json, $md5, $title);
            return back()->with('success', 'File uploaded successfully!');

        } elseif ($file_extension === 'gpkg' || $file_extension === 'geopkg') {
            // List layers
            exec("/bin/ogrinfo " . escapeshellarg($filePath), $output_array);
            $layer = 1;

            foreach ($output_array as $line) {
                // ogrinfo prints lines like: "1: LayerName (Polygon)"
                $firstChar = substr($line, 0, 1);
                if (!is_numeric($firstChar)) continue;

                $parts  = explode(':', $line, 2);
                $layerNameMaybe = isset($parts[1]) ? trim($parts[1]) : '';
                // Strip trailing " (…)" if present
                $final_output = preg_replace('/\s*\(.*\)$/', '', $layerNameMaybe);

                // Convert this layer to GeoJSON EPSG:4326
                $outAbs   = str_replace('.' . $file_extension, '', $filePath) . "_layer$layer.geojson";
                $outBase  = basename($outAbs);

                exec("/bin/ogr2ogr -f GeoJSON -t_srs EPSG:4326 " . escapeshellarg($outAbs) . ' ' . escapeshellarg($filePath) . ' ' . escapeshellarg($final_output), $convert_output);

                // Read & normalize converted GeoJSON
                if (!Storage::exists("$path/$outBase")) continue; // just in case
                $raw_layer = Storage::get("$path/$outBase");
                [$clean_layer, $json_layer] = $this->safeDecodeJson($raw_layer);

                // Store each layer as its own “file”
                $this->storeGeojsonUpload($userId, $path, $outBase, $clean_layer, $json_layer, $md5, $final_output);

                $layer++;
            }

            // Delete original gpkg (absolute path). Bye!
            @unlink($filePath);
            return back()->with('success', 'File uploaded successfully!');

        } elseif ($file_extension === 'shp') {
            // NOTE: Shapefiles need sidecar files; we assume they exist server-side.
            exec("/bin/ogrinfo " . escapeshellarg($filePath), $output_array);
            $layer = 1;

            foreach ($output_array as $line) {
                $firstChar = substr($line, 0, 1);
                if (!is_numeric($firstChar)) continue;

                $parts  = explode(':', $line, 2);
                $layerNameMaybe = isset($parts[1]) ? trim($parts[1]) : '';
                $final_output   = preg_replace('/\s*\(.*\)$/', '', $layerNameMaybe);

                $outAbs   = str_replace('.' . $file_extension, '', $filePath) . "_layer$layer.geojson";
                $outBase  = basename($outAbs);

                exec("/bin/ogr2ogr -f GeoJSON -t_srs EPSG:4326 " . escapeshellarg($outAbs) . ' ' . escapeshellarg($filePath) . ' ' . escapeshellarg($final_output), $convert_output);

                if (!Storage::exists("$path/$outBase")) continue;
                $raw_layer = Storage::get("$path/$outBase");
                [$clean_layer, $json_layer] = $this->safeDecodeJson($raw_layer);

                $this->storeGeojsonUpload($userId, $path, $outBase, $clean_layer, $json_layer, $md5, "{$final_output} (L$layer)");

                $layer++;
            }

            // Delete original shp (absolute path). Later, gator.
            @unlink($filePath);
            return back()->with('success', 'File uploaded successfully!');
        }

        // Unknown file type — nothing to do
        return back()->with('error', 'Unsupported file type. Please upload a GeoJSON, GPKG, or SHP.');
    }
}

