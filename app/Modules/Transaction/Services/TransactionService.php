<?php

namespace App\Modules\Transaction\Services;

use App\Modules\Transaction\DTOs\TransferDTO;
use App\Modules\Transaction\Exceptions\InsufficientBalanceException;
use App\Modules\Transaction\Exceptions\ShopkeeperTransferException;
use App\Modules\Transaction\Exceptions\UnauthorizedTransferException;
use App\Modules\Transaction\Jobs\SendTransferNotification;
use App\Modules\Transaction\Models\Transaction;
use App\Modules\Transaction\Repositories\TransactionRepositoryInterface;
use App\Modules\User\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class TransactionService
{
    public function __construct(
        protected TransactionRepositoryInterface $transactionRepository,
        protected UserRepositoryInterface $userRepository
    ) {
    }

    /**
     * Realiza uma transferência entre usuários.
     *
     * @throws ShopkeeperTransferException
     * @throws InsufficientBalanceException
     * @throws UnauthorizedTransferException
     * @throws \Exception
     */
    public function transfer(TransferDTO $dto): Transaction
    {
        /** @var Transaction $transaction */
        $transaction = DB::transaction(function () use ($dto): Transaction {
            return $this->executeTransfer($dto);
        });

        return $transaction;
    }

    /**
     * Executa a lógica da transferência dentro da transação.
     *
     * @param TransferDTO $dto
     * @return Transaction
     *
     * @throws \Exception
     */
    private function executeTransfer(TransferDTO $dto): Transaction
    {
        /** @var \App\Modules\User\Models\User|null $payer */
        $payer = $this->userRepository->findById($dto->payer);

        /** @var \App\Modules\User\Models\User|null $payee */
        $payee = $this->userRepository->findById($dto->payee);

        if (!$payer || !$payee) {
            throw new \Exception("User not found.");
        }

        if ($payer->type === 'shopkeeper') {
            throw new ShopkeeperTransferException();
        }

        if ($payer->wallet_balance < $dto->value) {
            throw new InsufficientBalanceException();
        }

        $authResponse = Http::get('https://util.devi.tools/api/v2/authorize');

        if (!$authResponse->json('data.authorization')) {
            throw new UnauthorizedTransferException();
        }

        $payer->wallet_balance -= $dto->value;
        $payer->save();

        $payee->wallet_balance += $dto->value;
        $payee->save();

        $transaction = $this->transactionRepository->create($dto);

        SendTransferNotification::dispatch(
            $payee->email,
            'Você recebeu uma transferência de R$ ' . number_format($dto->value, 2, ',', '.')
        )->onQueue('notifications');

        return $transaction;
    }
}
