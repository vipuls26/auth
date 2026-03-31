<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\JsonApi\JsonApiResource;

class BlogApiResource extends JsonApiResource
{
    /**
     * The resource's attributes.
     */
    public function toAttributes(Request $request): array
    {
        return [
            // 'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'status' => $this->status,
            'category' => $this->category_id,
            'name' => $this->user_id,
            'created_at' => DateFormat($this->created_at),
            'updated_at' => $this->updated_at,
        ];
    }

    /**
     * The resource's relationships.
     */
    public $relationships = [
        'user'=> UserResource::class,
        'category' => CategoryResource::class,
        'image' => ImageResource::class
    ];
}
