<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Status::insert([
            ['status' => 'Abierto',    'active' => '1', 'global_id' => 'GLOBAL_OPEN'],
            ['status' => 'Asignado',   'active' => '1', 'global_id' => 'GLOBAL_ASSIGNED'],
            ['status' => 'Reasignado', 'active' => '1', 'global_id' => 'GLOBAL_REASSIGNED'],
            ['status' => 'En progreso','active' => '1', 'global_id' => 'GLOBAL_IN_PROGRESS'],
            ['status' => 'Escalado',   'active' => '1', 'global_id' => 'GLOBAL_ESCALATED'],
            ['status' => 'Cerrado',    'active' => '1', 'global_id' => 'GLOBAL_CLOSED'],
            ['status' => 'Cancelado',  'active' => '1', 'global_id' => 'GLOBAL_CANCELLED'],
        ]);
    }
}
