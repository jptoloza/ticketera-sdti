<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [ 'role' => 'ADMINISTRADOR', 'global_key' => 'ROLE_ADMINISTRATOR' ],
            [ 'role' => 'AGENTE', 'global_key' => 'ROLE_AGENT' ],
            [ 'role' => 'USURIO', 'global_key' => 'ROLE_USER' ],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate([
                'role' => $role['role'],
                'global_key' => $role['global_key'],
                'active' => true
            ]);
        }
    }
}
