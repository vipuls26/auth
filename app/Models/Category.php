<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Hidden(['created_at','updated_at'])]
class Category extends Model
{


    protected $fillable = [
        'name'
    ];

    public function blogs(): BelongsTo
    {
        return $this->belongsTo(Blog::class);
    }
}
