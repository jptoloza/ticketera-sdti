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
            ['status' => 'Abierto', 'active' => true],
            ['status' => 'Asignado', 'active' => true],
            ['status' => 'Reasignado', 'active' => true],
            ['status' => 'En progreso', 'active' => true],
            ['status' => 'Escalado', 'active' => true],
            ['status' => 'Cerrado', 'active' => true],
            ['status' => 'Cancelado', 'active' => true],
        ]);
    }
}
