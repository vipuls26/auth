<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Blog extends Model
{
    //
    protected $fillable = [
        'title',
        'content',
        'status',
        'category_id',
        'user_id',
        'blog_id'
    ];

    // user relationship
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): HasOne
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    // image relationship
    public function image(): HasOne
    {
        return $this->hasOne(ImageUpload::class, 'blog_id');
    }
}
