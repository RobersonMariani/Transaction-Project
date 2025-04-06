<?php

namespace App\Modules\Transaction\Services;

use App\Modules\Transaction\DTOs\TransferDTO;
use App\Modules\Transaction\Exceptions\InsufficientBalanceException;
use App\Modules\Transaction\Exceptions\ShopkeeperTransferException;
use App\Modules\Transaction\Exceptions\UnauthorizedTransferException;
use App\Modules\Transaction\Jobs\SendTransferNotification;
use App\Modules\Transaction\Repositories\TransactionRepositoryInterface;
use App\Modules\User\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class TransactionService
{
    public function __construct(
        protected TransactionRepositoryInterface $transactionRepository,
        protected UserRepositoryInterface $userRepository
    ) {}

    public function transfer(TransferDTO $dto)
    {
        return DB::transaction(function () use ($dto) {
            $payer = $this->userRepository->findById($dto->payer);
            $payee = $this->userRepository->findById($dto->payee);

            if (!$payer || !$payee) {
                throw new \Exception("User not found.");
            }

            // Lojista não pode pagar
            if ($payer->type === 'shopkeeper') {
                throw new ShopkeeperTransferException();
            }

            // Verificar saldo
            if ($payer->wallet_balance < $dto->value) {
                throw new InsufficientBalanceException();
            }

            // Mock de autorização externa
            $authResponse = Http::get('https://util.devi.tools/api/v2/authorize');

            if (!$authResponse->json('data.authorization')) {
                throw new UnauthorizedTransferException();
            }

            // Atualiza saldos
            $payer->decrement('wallet_balance', $dto->value);
            $payee->increment('wallet_balance', $dto->value);

            // Registra transação
            $transaction = $this->transactionRepository->create($dto);

            // Mock de notificação
            SendTransferNotification::dispatch(
                $payee->email,
                'Você recebeu uma transferência de R$ ' . number_format($dto->value, 2, ',', '.')
            );

            return $transaction;
        });
    }
}
