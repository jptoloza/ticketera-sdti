<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        //     'login' => 'test',
        // ]);

        User::create([
            'name'     => 'MORALES MENDOZA',
            'rut'      => '018481447-1',
            'login'    => 'rmorale',
            'email'    => 'rmorale@uc.cl',
            'activate' => '1',
        ]);

        $this->call([
            RolesTableSeeder::class,
            PrioritiesTableSeeder::class,
            StatusTableSeeder::class,
        ]);
    }
}
