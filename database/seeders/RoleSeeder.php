<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

use function Symfony\Component\Clock\now;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::updateOrcreate([
            'name'=> 'superadmin',
            'created_at' => now(),
            'updated_at' => now()
        ]);

         Role::updateOrcreate([
            'name'=> 'admin',
            'created_at' => now(),
            'updated_at' => now()
        ]);

         Role::updateOrcreate([
            'name'=> 'user',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
