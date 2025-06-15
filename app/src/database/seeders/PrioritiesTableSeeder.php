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
        $priorities = [
            [ 'priority' => 'BAJA', 'global_key' => 'PRIORITY_LOW' ],
            [ 'priority' => 'MEDIA', 'global_key' => 'PRIORITY_HALF' ],
            [ 'priority' => 'ALTA', 'global_key' => 'PRIORITY_HIGH' ],
            [ 'priority' => 'CRÍTICA', 'global_key' => 'PRIORITY_CRITICAL' ]
        ];

        foreach ($priorities as $priority) {
            Priority::firstOrCreate([
                'priority' => $priority['priority'],
                'global_key' => $priority['global_key'],
                'active' => true
            ]);
        }
    }
}
