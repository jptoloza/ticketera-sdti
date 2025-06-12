<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Priority;

class PrioritiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $priorities = ['Baja', 'Media', 'Alta', 'Crítica'];

        foreach ($priorities as $priority) {
            Priority::firstOrCreate(['priority' => $priority], ['active' => true]);
        }
    }
}
