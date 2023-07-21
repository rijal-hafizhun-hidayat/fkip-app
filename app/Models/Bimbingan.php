<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bimbingan extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'bimbingan';
    protected $primaryKey = 'id';
    protected $guarded = [];
}
