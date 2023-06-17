<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('prodi')->insert([
            'nama' => 'Bimbingan dan Konseling'
        ], [
            'nama' => 'Pendidikan dan Sastra Indonesia'
        ], [
            'nama' => 'Pendidikan Bahasa Inggris'
        ], [
            'nama' => 'Pendidikan Pancasila dan Kewarganegaraan'
        ], [
            'nama' => 'Pendidikan Matematika'
        ], [
            'nama' => 'Pendidikan Fisika'
        ], [
            'nama' => 'Pendidikan Biologi'
        ], [
            'nama' => 'Pendidikan Guru Sekolah Dasar'
        ], [
            'nama' => 'Pendidikan Guru Pendidikan Anak Usia Dini'
        ], [
            'nama' => 'Pendidikan Vokasional Teknik Otomotif'
        ], [
            'nama' => 'Pendidikan Vokasional Teknik Elektronika'
        ]);
    }
}
