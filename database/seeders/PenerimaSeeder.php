<?php

namespace Database\Seeders;

use App\Models\LetterDisposisiUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PenerimaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LetterDisposisiUser::create([
            'user_id' => 1,
            'letter_disposisi_id' => 1
        ]);
    }
}
