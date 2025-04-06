<?php

namespace App\Modules\Transaction\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Transaction\Requests\TransferRequest;
use App\Modules\Transaction\Services\TransactionService;
use App\Modules\Transaction\DTOs\TransferDTO;
use Illuminate\Http\JsonResponse;

class TransactionController extends Controller
{
    public function __construct(
        protected TransactionService $transactionService
    ) {
    }

    public function transfer(TransferRequest $request): JsonResponse
    {
        $dto = new TransferDTO(
            payer: $request->getPayer(),
            payee: $request->getPayee(),
            value: $request->getValue()
        );

        $transaction = $this->transactionService->transfer($dto);

        return response()->json([
            'message' => 'Transfer successful.',
            'data' => $transaction
        ], 201);
    }
}
