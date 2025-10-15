<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dashboard;
use App\Models\DashboardWidget;
use App\Models\DashboardWidgetType;
use App\Models\FileUpload;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str; //for Str::random()
use IcehouseVentures\LaravelChartjs\Facades\Chartjs;

class DashboardController extends Controller
{
    public function show_dashboard($id)
    {
	    ob_start('ob_gzhandler'); // Enable compression to the browser
	    $userId = Auth::id();
        # Get all files
        $my_files = FileUpload::select('filename')->where('user_id', '=', $userId)->get();
        $geojson_array = [];
        $geojson_chart_array = [];
	    foreach ($my_files as $my_file) {
            $file = $my_file['filename'];
            $geojson_array[] = ['filename' => preg_replace('/[^A-Za-z0-9\_\.]/', '', basename($file))]; //$geojson_array[] = geojson_array.append()
        }

	    # Get Generalized Dashboard
        $dashboard_info = Dashboard::where('user_id', '=', $userId)
            ->where('id', '=', $id)
            ->get(); // Get the widget with the right id, but ensure we don't open widgets that aren't ours by filtering by user id.
        $get_widgets = DashboardWidget::where('dashboard_id', '=', $id)
	        ->get(); // Get widgets for this dashboard

	    # Iterate Widgets
        foreach ($get_widgets as $get_widget) {
            #var_dump($get_widget);

            #die;
            $chart = [];
            $values = [];
            $values_md = [];
            $labels = [];
            $decode_metadata = json_decode($get_widget['metadata'], true);
            $get_map_filename = $decode_metadata['map_filename'];

            if ($get_widget['widget_type_id'] == 1) { # I'm the map i'm the map (he's the map he's the map) I'M THE MAP!!
                $get_widget['map_json'] = Storage::get("users/{$userId}/{$get_map_filename}");
		        $get_widget['random_id'] = Str::random();
		        $get_widget['filename'] = preg_replace('/[^A-Za-z0-9\_\.]/', '', basename($get_map_filename));
            } elseif ($get_widget['widget_type_id'] > 1 && $get_widget['widget_type_id'] <= 4) { # Handle Charts
                $values = [];
                $geojson = FileUpload::select('geojson')
                    ->where('filename', '=', $get_map_filename)
                    ->where('user_id', '=', $userId)
                    ->get();
                $json_version = json_decode($geojson->value('geojson'), true) ?? ['features' => []];

                // Normalize the Y selection. UI sends labels like "COUNT" or "SUM FieldName".
                [$agg, $yField] = $this->normalizeYAxis($decode_metadata['y_axis'] ?? 'COUNT');
                $xField = $decode_metadata['x_axis'] ?? null;

                if ($agg === 'COUNT') { # Handle Count
                    foreach ($json_version['features'] as $feature) {
                        $key = $feature['properties'][$xField] ?? null;
                        if ($key === null) continue;
                        if (!isset($values_md[$key])) {
                            $values_md[$key] = 1;
                        } else {
                            $values_md[$key] = $values_md[$key] + 1;
                        }
                    }
                    $labels = array_keys($values_md);
                    if ($get_widget['widget_type_id'] == 4) { # Piecharts don't like labels to be numberical, so convert them all
                        $labels = array_map(function($value) { return (string)$value; }, $labels);
                    }
                    $values = array_values($values_md);

                } else { # Handle Sum (aggregate = SUM, field = $yField)
                    foreach ($json_version['features'] as $feature) {
                        $key = $feature['properties'][$xField] ?? null;
                        if ($key === null) continue;

                        $raw = $feature['properties'][$yField] ?? null;
                        if (!is_numeric($raw)) continue; // skip headers/strings/nulls
                        $val = (float)$raw;

                        if (!isset($values_md[$key])) {
                            $values_md[$key] = $val;
                        } else {
                            $values_md[$key] += $val;
                        }
                    }
                    $labels = array_keys($values_md);
                    if ($get_widget['widget_type_id'] == 4) {
                        // Keep it consistent for pies
                        $labels = array_map(fn($v) => (string)$v, $labels);
                    }
                    $values = array_values($values_md);
                }

                $chart_types = [2 => 'line', 3 => 'bar', 4 => 'pie', 5 => 'table']; # TODO: Add the chart value name to the database as a column instead of this
                if ($get_widget['widget_type_id'] == 4) { # Show pie stuff on the right. Else above
                    $label_location = 'right';
                } else {
                    $label_location = 'top';
                }

                // Build dataset; give pies explicit colors so slices show up nicely
                $dataset = [
                    "label" => $decode_metadata['x_axis'] ?? '',
                    "data" => $values,
                    "fill" => true, //calculus (y/n)
                    "pointRadius" => 0,
                    "borderWidth" => 1,
                ];
                if ($get_widget['widget_type_id'] == 4) {
                    $dataset["backgroundColor"] = $this->makeColors(count($labels));
                }

                $chart = Chartjs::build() //makes empty chart
                    ->name("Chart".Str::random()) //fill da chart!!!! with what we just did!!!!!!!
                    ->type($chart_types[$get_widget['widget_type_id']])
                    ->size(['width' => 400, 'height' => 200]) 
                    ->labels($labels)
                    ->datasets([$dataset])
                    ->options([
                        "interaction" =>[
                            "mode" => "nearest", // or 'index'
                            "intersect" => false
                        ],
                        "hover" => [
                            "mode" => "nearest", // or 'index'
                            "intersect" => false
                        ],
                        "plugins" => [
                            "legend" => [
                                "position" => $label_location,
                            ]
                        ],
                        "responsive" => true,
                        "maintainAspectRatio" => false, // This is true by default
                    ]);

                $get_widget['chart'] = $chart;
            }
	    }
	    $get_widget_types = DashboardWidgetType::get(); // Get all widget types
        $array = ['dashboard_info' => $dashboard_info[0], 'widgets' => $get_widgets, 'widget_types' => $get_widget_types, 'all_geojsons' => $geojson_array];

        return view('profile.dashboard', $array);
    }

    public function add_widgets($id) { // Show the add widgets page
        $dashboard_info = Dashboard::where('user_id', '=', Auth::id())
            ->where('id', '=', $id)
            ->get();
        $my_files = FileUpload::select('filename', 'title')->where('user_id', '=', Auth::id())->get(); # Limit to filename only because it will be sloooooow with json in the db
        $get_widget_types = DashboardWidgetType::get(); // Get all widget types
        $array = ['dashboard_info' => $dashboard_info[0], 'widget_types' => $get_widget_types, 'files' => $my_files];
        return view('profile.add-widgets', $array);
    }

    public function add_widget($id, Request $request) { // Add the widget to the database
        $request->validate([
            'widget_type' => ['required'],
            'map_filename' => ['required'],
        ]);
        //if not map, validate x and y axis
        if ($request->widget_type != 1) {
            $request->validate([
                'x_axis' => ['required'],
                'y_axis' => ['required']
            ]);
        }
        if (!$request->widget_name) { # Did we not get a name? We should use the file Title
            $get_filename_title = FileUpload::select('title')
                ->where('user_id', '=', Auth::id())
                ->where('filename', '=', $request->map_filename)
                ->get();
            if ($request->widget_type > 1) { # Give our own name for the widget if they leave it blank
                if ($request->y_axis == 'COUNT') { # If it's count, don't include SUM 
                    $widget_name = "$request->y_axis BY $request->x_axis ";
                } else { 
                    $widget_name = "SUM OF $request->y_axis BY $request->x_axis";
                }
            } else { # Use the maps uploaded name
                $widget_name = $get_filename_title->value('title');
            }
        } else { # Else use what the user set the title to
            $widget_name = $request->widget_name;
        }
        $widget = new DashboardWidget;
        $widget->user_id = auth()->id();
        $widget->dashboard_id = $id;
        $widget->name = $widget_name;
        $widget->widget_type_id = $request->widget_type;
        if ($request->widget_type == 1) { #  Maps
            $metadata = json_encode(['map_filename' => $request->map_filename]);
        } elseif ($request->widget_type > 1){ # handle all charts
            $metadata = json_encode(['x_axis' => $request->x_axis, 'y_axis' => $request->y_axis, 'map_filename' => $request->map_filename]);
        }
        $widget->metadata = $metadata;
        $widget->save();
        return redirect()->route('profile.dashboard', ['id' => $id]);
    }

    public function delete_widget(Request $request) {
        $del_id = DashboardWidget::where('user_id', '=', Auth::id())->where('id', '=', $request->id);
        $del_id->delete();
        return redirect()->route('profile.dashboard', ['id' => $request->dash_id]);
    }

    public function get_geojson($filename) {
        ini_set('memory_limit', -1); # Tell laravel not to be greedy with memory.. GIVE IT ALL TO ME!!!
	    ob_start('ob_gzhandler');
	    $real_filename = $filename.".geojson";
	    $getfiles = FileUpload::select('geojson')
            ->where('filename', '=', $real_filename)
			->where('user_id', '=', Auth::id())
			->get();
	    return response()->json(json_decode($getfiles->value('geojson'), true))->header('Cache-Control', 'max-age=3600, public');
    }

    public function delete_dashboard(Request $request) {
        $del_id = Dashboard::where('user_id', '=', Auth::id())->where('id', '=', $request->id);
        $del_id->delete();
        $widgets_to_del = DashboardWidget::where('user_id', '=', Auth::id())
            ->where('dashboard_id', '=', $request->id);
        $widgets_to_del->delete();
        return redirect()->route('home');
    }

    public function updateBounds(Request $request) {
        $request->validate([
            'widget_id' => ['required', 'integer'],
            'bounds' => ['required', 'array'],
            'bounds._northEast.lat' => ['required', 'numeric'],
            'bounds._northEast.lng' => ['required', 'numeric'],
            'bounds._southWest.lat' => ['required', 'numeric'],
            'bounds._southWest.lng' => ['required', 'numeric'],
        ]);

        $userId = Auth::id();

        // 1) Find the widget and ensure it belongs to the user
        $widget = DashboardWidget::where('user_id', $userId)
            ->where('id', $request->integer('widget_id'))
            ->firstOrFail();

        // Map widgets don't have x/y axes; only charts (2..4) are refreshable here
        if (!($widget->widget_type_id > 1 && $widget->widget_type_id <= 4)) {
            return response()->json(['labels' => [], 'datasets' => []]);
        }

        $meta = json_decode($widget->metadata, true);
        $xAxis = $meta['x_axis'] ?? null;
        [$agg, $yField] = $this->normalizeYAxis($meta['y_axis'] ?? 'COUNT');
        $mapFilename = $meta['map_filename'] ?? null;

        if (!$xAxis || !$yField || !$mapFilename) {
            return response()->json(['labels' => [], 'datasets' => []]);
        }

        // 2) Load the GeoJSON from DB for this file & user
        $geo = FileUpload::select('geojson')
            ->where('filename', '=', $mapFilename)
            ->where('user_id', '=', $userId)
            ->first();

        if (!$geo) {
            return response()->json(['labels' => [], 'datasets' => []]);
        }

        $json = json_decode($geo->geojson, true);
        if (!is_array($json) || ($json['type'] ?? '') !== 'FeatureCollection') {
            return response()->json(['labels' => [], 'datasets' => []]);
        }

        // 3) Bounds
        $ne = $request->input('bounds._northEast');
        $sw = $request->input('bounds._southWest');
        $north = (float) $ne['lat'];
        $east  = (float) $ne['lng'];
        $south = (float) $sw['lat'];
        $west  = (float) $sw['lng'];

        // 4) Filter features to those whose representative point falls in bbox
        $filtered = [];
        foreach ($json['features'] as $f) {
            $pt = $this->featureRepresentativePoint($f);
            if (!$pt) continue;
            if ($this->pointInBounds($pt['lat'], $pt['lng'], $south, $west, $north, $east)) {
                $filtered[] = $f;
            }
        }

        // 5) Recompute chart data (mirrors show_dashboard)
        $values_md = [];
        if ($agg === 'COUNT') {
            foreach ($filtered as $f) {
                $key = $f['properties'][$xAxis] ?? null;
                if ($key === null) continue;
                if (!isset($values_md[$key])) $values_md[$key] = 1;
                else $values_md[$key]++;
            }
            $labels = array_keys($values_md);
            if ($widget->widget_type_id == 4) { // pie labels as strings
                $labels = array_map(fn($v) => (string)$v, $labels);
            }
            $values = array_values($values_md);
        } else { // SUM
            foreach ($filtered as $f) {
                $key = $f['properties'][$xAxis] ?? null;
                $raw = $f['properties'][$yField] ?? null;
                if ($key === null) continue;
                if (!is_numeric($raw)) continue;
                $val = (float)$raw;
                if (!isset($values_md[$key])) $values_md[$key] = $val;
                else $values_md[$key] += $val;
            }
            $labels = array_keys($values_md);
            if ($widget->widget_type_id == 4) {
                $labels = array_map(fn($v) => (string)$v, $labels);
            }
            $values = array_values($values_md);
        }

        $dataset = [
            'label' => $xAxis,
            'data'  => $values,
            'fill'  => true,
            'pointRadius' => 0,
            'borderWidth' => 1,
        ];
        if ($widget->widget_type_id == 4) {
            $dataset['backgroundColor'] = $this->makeColors(count($labels));
        }

        return response()->json([
            'labels'   => $labels,
            'datasets' => [ $dataset ],
        ]);
    }

    /**
     * Normalize a y_axis selection like "COUNT" or "SUM Foo" into [agg, field].
     * Returns ['COUNT','COUNT'] for COUNT to make branching easy.
     */
    private function normalizeYAxis(?string $raw): array
    {
        $raw = trim((string)$raw);
        if (strtoupper($raw) === 'COUNT') {
            return ['COUNT', 'COUNT'];
        }
        if (stripos($raw, 'SUM ') === 0) {
            return ['SUM', trim(substr($raw, 4))];
        }
        // If UI ever passes just a field name, treat as SUM of that field
        return ['SUM', $raw];
    }

    /**
     * Representative point for a feature.
     * - Point → that point.
     * - Polygon/MultiPolygon → first ring’s first coord (simple/fast).
     *   (For production accuracy, compute real centroid/intersection or use PostGIS.)
     */
    private function featureRepresentativePoint(array $feature): ?array
    {
        $geom = $feature['geometry'] ?? null;
        if (!$geom || !isset($geom['type'])) return null;

        if ($geom['type'] === 'Point') {
            $c = $geom['coordinates'] ?? null;
            if (is_array($c) && count($c) >= 2) {
                return ['lat' => (float)$c[1], 'lng' => (float)$c[0]];
            }
        }

        if ($geom['type'] === 'Polygon' && !empty($geom['coordinates'][0][0])) {
            $c = $geom['coordinates'][0][0];
            return ['lat' => (float)$c[1], 'lng' => (float)$c[0]];
        }

        if ($geom['type'] === 'MultiPolygon' && !empty($geom['coordinates'][0][0][0])) {
            $c = $geom['coordinates'][0][0][0];
            return ['lat' => (float)$c[1], 'lng' => (float)$c[0]];
        }

        // TODO: handle LineString/MultiLineString if needed
        return null;
    }

    private function makeColors(int $n): array
    {
        if ($n <= 0) return [];
        $colors = [];
        $step = max(1, intdiv(360, max(6, min(24, $n))));
        $h = 0;
        for ($i = 0; $i < $n; $i++) {
            $colors[] = sprintf('hsl(%d, 65%%, 55%%)', $h);
            $h = ($h + $step) % 360;
        }
        return $colors;
    }

    private function pointInBounds(float $lat, float $lng, float $south, float $west, float $north, float $east): bool
    {
        // no anti-meridian handling (keep it simple)
        return $lat >= $south && $lat <= $north && $lng >= $west && $lng <= $east;
    }
}
