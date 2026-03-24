<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Throwable;

class Submission extends Model
{
    protected $fillable = [
        'form_id',
        'content',
        'ip_address',
    ];

    protected $casts = [
        'content' => 'array', // Automatically decodes JSON to Array
    ];

    protected static function booted(): void
    {
        static::deleting(function (Submission $submission): void {
            foreach ($submission->uploadedFilePaths() as $path) {
                foreach (['local', 'public'] as $disk) {
                    try {
                        // Missing files should not block submission deletion.
                        if (Storage::disk($disk)->exists($path)) {
                            Storage::disk($disk)->delete($path);
                        }
                    } catch (Throwable) {
                        continue;
                    }
                }
            }
        });
    }

    protected function uploadedFilePaths(): array
    {
        $paths = [];
        $content = (array) $this->content;

        array_walk_recursive($content, function ($value) use (&$paths): void {
            if (is_string($value) && str_starts_with($value, 'submissions/')) {
                $paths[] = $value;
            }
        });

        return array_values(array_unique($paths));
    }

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
