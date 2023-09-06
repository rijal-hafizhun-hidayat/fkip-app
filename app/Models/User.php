<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'username',
        'role',
        'password',
        'email',
        'prodi',
        'id_dpl',
        'id_guru_pamong',
        'id_mahasiswa'
    ];

    public const ROLE_ID_ADMIN = 1;
    public const ROLE_DPL_ID = 2;
    public const ROLE_ID_GURU_PAMONG = 3;
    public const ROLE_ID_MAHASISWA = 4;
    public const ROLE_ID_DKL = 5;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
