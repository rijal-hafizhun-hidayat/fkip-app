<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'nama' => Str::random(5),
            'username' => Str::random(5),
            'email' => Str::random(5).'@gmail.com',
            'role' => 1, //admin
            'password' => Hash::make('password'),
            'prodi' => 'FKIP'
        ]);
    }
}
