<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'heading',
        'description',
        'slug',
        'schema',
        'settings',
    ];

    protected $casts = [
        'schema' => 'array', // Automatically decodes JSON to Array
        'settings' => 'array',
        'is_active' => 'boolean'
    ];

    protected static function booted(): void
    {
        static::deleting(function (Form $form): void {
            $form->submissions()->chunkById(100, function ($submissions): void {
                foreach ($submissions as $submission) {
                    $submission->delete();
                }
            });
        });
    }

    public function getFields()
    {
        return $this->schema['fields'] ?? [];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}
