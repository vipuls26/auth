<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        Category::updateOrcreate([
            'name' => 'fun',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Category::updateOrcreate([
            'name' => 'knowledge',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Category::updateOrcreate([
            'name' => 'current affairs',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Category::updateOrcreate([
            'name' => 'science',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Category::updateOrcreate([
            'name' => 'technology',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Category::updateOrcreate([
            'name' => 'space',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Category::updateOrcreate([
            'name' => 'entertainment',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
