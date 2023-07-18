<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;
    protected $table = 'nilai';
    protected $primaryKey = 'id';
    protected $casts = [
        'nilai_kompeten_nb' => 'array',
        'nilai_kompeten_nc' => 'array',
        'nilai_kompeten_nd' => 'array',
        'nilai_kompeten_ne' => 'array'
    ];
    protected $guarded = [];
}
