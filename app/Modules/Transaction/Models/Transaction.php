<?php

namespace App\Modules\Transaction\Models;

use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method static Transaction create(array<string, mixed> $attributes = [])
 * @method static \Database\Factories\Modules\Transaction\Models\TransactionFactory factory(...$parameters)
 * @mixin Builder<Transaction>
 */
class Transaction extends Model
{
    /** @use \Illuminate\Database\Eloquent\Factories\HasFactory<\Database\Factories\Modules\Transaction\Models\TransactionFactory> */
    use HasFactory;

    /** @var array<int, string> */
    protected $fillable = [
        'payer_id',
        'payee_id',
        'value',
    ];

    /**
     * @return BelongsTo<User, Transaction>
     */
    public function payer(): BelongsTo
    {
        /** @var BelongsTo<User, Transaction> */
        return $this->belongsTo(User::class, 'payer_id');
    }

    /**
     * @return BelongsTo<User, Transaction>
     */
    public function payee(): BelongsTo
    {
        /** @var BelongsTo<User, Transaction> */
        return $this->belongsTo(User::class, 'payee_id');
    }
}
