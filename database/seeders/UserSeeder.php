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
            'nama_depan' => Str::random(5),
            'nama' => Str::random(5),
            'username' => 'admin',
            'role' => 1, //admin
            'password' => Hash::make('password'),
            'email' => 'rijal.1344@gmail.com'
        ]);
    }
}
