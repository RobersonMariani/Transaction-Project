<?php

namespace App\Modules\User\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cpf',
        'email',
        'password',
        'type',
        'wallet_balance',
    ];

    protected $hidden = ['password'];
}
