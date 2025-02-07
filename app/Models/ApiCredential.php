<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class ApiCredential extends Model
{
    use HasFactory,HasApiTokens;

    protected $fillable = [
        'username',
        'password',
        'status',
        'refresh_token',
        'last_used_at'
    ];

    // If you're using hashed passwords
    protected $hidden = [
        'password',
    ];

    // Accessors, mutators, and additional logic can be added here
}
