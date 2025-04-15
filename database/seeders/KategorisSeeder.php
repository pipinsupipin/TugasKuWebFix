<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategorisSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kategoris')->insert([
            ['nama_kategori' => 'Tugas'],
            ['nama_kategori' => 'Proyek'],
            ['nama_kategori' => 'Rapat'],
            ['nama_kategori' => 'Quiz'],
            ['nama_kategori' => 'Ujian'],
            ['nama_kategori' => 'Les rutin'],
            ['nama_kategori' => 'Lainnya'],
        ]);
    }
}