<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // role
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin')
        ]);
        $admin->assignRole('Admin');

        // direktur
        $direktur = User::create([
            'name' => 'direktur',
            'email' => 'direktur@gmail.com',
            'password' => bcrypt('password')
        ]);

        $direktur->assignRole('Direktur');

        // wakil_direktur
        $wakil_direktur = User::create([
            'name' => 'Wakil Direktur',
            'email' => 'wakildirektur@gmail.com',
            'password' => bcrypt('password')
        ]);
        $wakil_direktur->assignRole('Wakil Direktur');

        // k_unit
        $k_unit = User::create([
            'name' => 'K Unit',
            'email' => 'kunit@gmail.com',
            'password' => bcrypt('password')
        ]);
        $k_unit->assignRole('K-Unit');

        // karyawan
        $karyawan = User::create([
            'name' => 'Karyawan',
            'email' => 'karyawan@gmail.com',
            'password' => bcrypt('password')
        ]);
        $karyawan->assignRole('Karyawan');
    }
}
