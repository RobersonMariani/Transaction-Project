<?php

namespace App\Modules\Transaction\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Transaction\Requests\TransferRequest;
use App\Modules\Transaction\Services\TransactionService;
use App\Modules\Transaction\DTOs\TransferDTO;

class TransactionController extends Controller
{
    public function __construct(
        protected TransactionService $transactionService
    ) {}

    public function transfer(TransferRequest $request)
    {
        $dto = new TransferDTO(
            payer: $request->payer,
            payee: $request->payee,
            value: $request->value
        );

        $transaction = $this->transactionService->transfer($dto);

        return response()->json([
            'message' => 'Transfer successful.',
            'data' => $transaction
        ], 201);
    }
}
