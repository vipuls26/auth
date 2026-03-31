<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            // 'id' => $this->id,
            'title' =>$this->title,
            'content' => $this->content,
            'status' =>$this->status,
            'category' => CategoryResource::make($this->category),
            'name' => UserResource::make($this->user),
            'image' => ImageResource::make($this->image),
            'created_at' => DateFormat($this->created_at),
            'updated_at' => $this->updated_at,
        ];
    }
}
