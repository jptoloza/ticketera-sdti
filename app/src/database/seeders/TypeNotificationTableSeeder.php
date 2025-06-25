<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TypeNotification;

class TypeNotificationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TypeNotification::insert([
            ['type' => 'NEW'],
            ['type' => 'MESSAGE'],
            ['type' => 'ADMIN'],
        ]);
    }
}
