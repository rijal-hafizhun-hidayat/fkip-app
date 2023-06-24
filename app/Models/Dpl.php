<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dpl extends Model
{
    use HasFactory;
    protected $table = 'dpl';
    protected $primaryKey = 'id';
    protected $guarded = [];
}
