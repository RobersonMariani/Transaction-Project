<?php

namespace Tests\Unit\Modules\Transaction;

use App\Modules\Transaction\DTOs\TransferDTO;
use App\Modules\Transaction\Repositories\TransactionRepositoryInterface;
use App\Modules\Transaction\Services\TransactionService;
use App\Modules\User\Models\User;
use App\Modules\User\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Mockery;
use Tests\TestCase;

class TransactionServiceTest extends TestCase
{
    public function test_should_throw_exception_when_payer_is_shopkeeper()
    {
        $shopkeeper = new User([
            'id' => 1,
            'type' => 'shopkeeper',
            'wallet_balance' => 100,
        ]);
        $payee = new User(['id' => 2, 'type' => 'common']);

        $mockUserRepo = Mockery::mock(UserRepositoryInterface::class);
        $mockUserRepo->shouldReceive('findById')->with(1)->andReturn($shopkeeper);
        $mockUserRepo->shouldReceive('findById')->with(2)->andReturn($payee);

        $mockTransactionRepo = Mockery::mock(TransactionRepositoryInterface::class);

        DB::shouldReceive('transaction')->andReturnUsing(fn($callback) => $callback());

        $service = new TransactionService($mockTransactionRepo, $mockUserRepo);
        $this->expectExceptionMessage('Shopkeepers are not allowed to transfer funds.');

        $dto = new TransferDTO(payer: 1, payee: 2, value: 10.0);
        $service->transfer($dto);
    }

    public function test_should_throw_exception_when_balance_is_insufficient()
    {
        $payer = new User([
            'id' => 1,
            'type' => 'common',
            'wallet_balance' => 5,
        ]);
        $payee = new User(['id' => 2, 'type' => 'common']);

        $mockUserRepo = Mockery::mock(UserRepositoryInterface::class);
        $mockUserRepo->shouldReceive('findById')->with(1)->andReturn($payer);
        $mockUserRepo->shouldReceive('findById')->with(2)->andReturn($payee);

        $mockTransactionRepo = Mockery::mock(TransactionRepositoryInterface::class);

        DB::shouldReceive('transaction')->andReturnUsing(fn($callback) => $callback());

        $service = new TransactionService($mockTransactionRepo, $mockUserRepo);
        $this->expectExceptionMessage('Insufficient balance.');

        $dto = new TransferDTO(payer: 1, payee: 2, value: 10.0);
        $service->transfer($dto);
    }

    public function test_should_throw_exception_when_authorization_fails()
    {
        $payer = new User([
            'id' => 1,
            'type' => 'common',
            'wallet_balance' => 100,
        ]);
        $payee = new User(['id' => 2, 'type' => 'common']);

        $mockUserRepo = Mockery::mock(UserRepositoryInterface::class);
        $mockUserRepo->shouldReceive('findById')->with(1)->andReturn($payer);
        $mockUserRepo->shouldReceive('findById')->with(2)->andReturn($payee);

        $mockTransactionRepo = Mockery::mock(TransactionRepositoryInterface::class);

        DB::shouldReceive('transaction')->andReturnUsing(fn($callback) => $callback());

        Http::shouldReceive('get')
            ->once()
            ->andReturn(new \Illuminate\Http\Client\Response(
                new \GuzzleHttp\Psr7\Response(200, [], json_encode(['message' => 'Não autorizado']))
            ));

        $service = new TransactionService($mockTransactionRepo, $mockUserRepo);
        $this->expectExceptionMessage('Transfer not authorized by external service.');

        $dto = new TransferDTO(payer: 1, payee: 2, value: 50.0);
        $service->transfer($dto);
    }
}
