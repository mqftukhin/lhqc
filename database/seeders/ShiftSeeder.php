<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Shift;

class ShiftSeeder extends Seeder
{
    public function run(): void
    {
        Shift::insert([
            ['nama_shift' => 'Shift 1', 'jam_mulai' => '07:00:00', 'jam_selesai' => '15:59:59'],
            ['nama_shift' => 'Shift 2', 'jam_mulai' => '16:00:00', 'jam_selesai' => '23:59:59'],
            ['nama_shift' => 'Shift 3', 'jam_mulai' => '00:00:00', 'jam_selesai' => '06:59:59'],
        ]);
    }
}
