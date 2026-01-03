<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    use HasFactory, Notifiable;

    // Field yang boleh diisi
    protected $fillable = [
        'username',
        'password',
        'role',
    ];

    // Field yang disembunyikan
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Jika Anda ingin menggunakan username untuk login, pastikan fieldnya ada di sini
}