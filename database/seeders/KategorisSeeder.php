<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriTugas;
use App\Models\User;

class KategorisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Default categories for new users
        $defaultCategories = [
            'Tugas', 'Proyek', 'Rapat', 'Ujian'
        ];

        $users = User::all();

        foreach ($users as $user) {
            foreach ($defaultCategories as $categoryName) {
                KategoriTugas::firstOrCreate([
                    'user_id' => $user->id,
                    'nama_kategori' => $categoryName,
                ]);
            }
        }
    }
}