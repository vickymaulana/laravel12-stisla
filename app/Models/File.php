<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'original_name',
        'path',
        'mime_type',
        'size',
        'extension',
        'folder',
        'description',
        'is_public',
    ];

    protected $casts = [
        'is_public' => 'boolean',
    ];

    /**
     * Get the user that uploaded the file.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get file size in human readable format
     */
    public function getFormattedSizeAttribute()
    {
        $bytes = $this->size;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Get file URL
     */
    public function getUrlAttribute()
    {
        return Storage::url($this->path);
    }

    /**
     * Check if file is an image
     */
    public function isImage()
    {
        return str_starts_with($this->mime_type, 'image/');
    }

    /**
     * Check if file is a document
     */
    public function isDocument()
    {
        $docMimes = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ];

        return in_array($this->mime_type, $docMimes);
    }

    /**
     * Get icon class based on file type
     */
    public function getIconAttribute()
    {
        if ($this->isImage()) {
            return 'fa-file-image text-info';
        }

        if ($this->mime_type === 'application/pdf') {
            return 'fa-file-pdf text-danger';
        }

        if (in_array($this->extension, ['doc', 'docx'])) {
            return 'fa-file-word text-primary';
        }

        if (in_array($this->extension, ['xls', 'xlsx'])) {
            return 'fa-file-excel text-success';
        }

        if (in_array($this->extension, ['zip', 'rar', '7z'])) {
            return 'fa-file-archive text-warning';
        }

        if (in_array($this->extension, ['mp4', 'avi', 'mov'])) {
            return 'fa-file-video text-purple';
        }

        if (in_array($this->extension, ['mp3', 'wav', 'ogg'])) {
            return 'fa-file-audio text-orange';
        }

        return 'fa-file text-muted';
    }
}
