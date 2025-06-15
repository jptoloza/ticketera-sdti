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
            ['status' => 'ABIERTO',     'active' => true, 'global_key' => 'STATUS_OPEN'],
            ['status' => 'ASIGNADO',    'active' => true, 'global_key' => 'STATUS_ASSIGNED'],
            ['status' => 'REASIGNADO',  'active' => true, 'global_key' => 'STATUS_REASSIGNED'],
            ['status' => 'EN EJECUCIÓN','active' => true, 'global_key' => 'STATUS_IN_PROGRESS'],
            ['status' => 'ESCALADO',    'active' => true, 'global_key' => 'STATUS_ESCALATED'],
            ['status' => 'CERRADO',     'active' => true, 'global_key' => 'STATUS_CLOSED'],
            ['status' => 'CANCELADO',   'active' => true, 'global_key' => 'STATUS_CANCELLED'],
        ]);
    }
}
