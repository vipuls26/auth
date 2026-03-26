<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class ImageUpload extends Model
{
    protected $fillable = [
        'name',
        'image_path',
        'user_id',
        'blog_id'
    ];

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function blog(): BelongsTo
    {
        return $this->belongsTo(Blog::class, 'blog_id');
    }
}
