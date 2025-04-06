<?php

namespace App\Modules\User\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property int $id
 * @property string $name
 * @property string $cpf
 * @property string $email
 * @property string $password
 * @property string $type
 * @property float $wallet_balance
 *
 * @method static \Database\Factories\Modules\User\Models\UserFactory factory(...$parameters)
 * @mixin Builder<User> *
 *
 */
class User extends Authenticatable
{
    /** @use \Illuminate\Database\Eloquent\Factories\HasFactory<\Database\Factories\Modules\User\Models\UserFactory> */
    use HasFactory, SoftDeletes;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'cpf',
        'email',
        'password',
        'type',
        'wallet_balance',
    ];

    /**
     * @var array<int, string>
     */
    protected $hidden = ['password'];
}
