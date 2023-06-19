<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuruPamong extends Model
{
    use HasFactory;
    protected $table = 'guru_pamong';
    protected $primaryKey = 'id';
    protected $guarded = [];
}
