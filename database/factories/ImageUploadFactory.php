<?php

namespace Database\Factories;

use App\Models\Blog;
use App\Models\ImageUpload;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ImageUpload>
 */
class ImageUploadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dir = storage_path('app/public/blog');
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        return [
            'name' => fake()->name(),
            'image_path' => 'blog/' . basename(fake()->image($dir, 640, 480, null, false)),
            'user_id'  => User::factory(),
            'blog_id' => Blog::factory(),
        ];
    }
}
