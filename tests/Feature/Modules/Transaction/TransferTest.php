<?php

namespace Tests\Feature\Modules\Transaction;

use App\Modules\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class TransferTest extends TestCase
{
    use RefreshDatabase;

    public function test_successful_transfer()
    {
        // Mock da resposta externa
        Http::fake([
            'https://util.devi.tools/api/v2/authorize' => Http::response([
                'status' => 'success',
                'data' => [
                    'authorization' => true
                ]
            ], 200),
            'https://util.devi.tools/api/v1/notify' => Http::response([], 200),
        ]);

        $payer = User::factory()->create([
            'type' => 'common',
            'wallet_balance' => 1000,
        ]);

        $payee = User::factory()->create([
            'type' => 'shopkeeper',
            'wallet_balance' => 500,
        ]);

        $payload = [
            'payer' => $payer->id,
            'payee' => $payee->id,
            'value' => 200.0,
        ];

        $response = $this->postJson('/api/transfer', $payload);

        $response->assertStatus(201)
            ->assertJsonFragment(['message' => 'Transfer successful.']);

        $this->assertDatabaseHas('transactions', [
            'payer_id' => $payer->id,
            'payee_id' => $payee->id,
            'value' => 200.0,
        ]);

        $this->assertEquals(800.0, $payer->fresh()->wallet_balance);
        $this->assertEquals(700.0, $payee->fresh()->wallet_balance);
    }

    public function test_transfer_should_fail_if_not_authorized()
    {
        Http::fake([
            'https://util.devi.tools/api/v2/authorize' => Http::response([
                'status' => 'fail',
                'data' => [
                    'authorization' => false
                ]
            ], 200),
        ]);

        $payer = User::factory()->create([
            'type' => 'common',
            'wallet_balance' => 100,
        ]);

        $payee = User::factory()->create([
            'type' => 'shopkeeper',
            'wallet_balance' => 100,
        ]);

        $response = $this->postJson('/api/transfer', [
            'payer' => $payer->id,
            'payee' => $payee->id,
            'value' => 50,
        ]);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('transactions', [
            'payer_id' => $payer->id,
            'payee_id' => $payee->id,
        ]);
    }

    public function test_transfer_should_fail_if_payer_is_shopkeeper()
    {
        Http::fake([
            'https://util.devi.tools/api/v2/authorize' => Http::response([
                'status' => 'success',
                'data' => [
                    'authorization' => true
                ]
            ], 200),
        ]);

        $payer = User::factory()->create([
            'type' => 'shopkeeper',
            'wallet_balance' => 1000,
        ]);

        $payee = User::factory()->create([
            'type' => 'common',
            'wallet_balance' => 100,
        ]);

        $response = $this->postJson('/api/transfer', [
            'payer' => $payer->id,
            'payee' => $payee->id,
            'value' => 100,
        ]);

        $response->assertStatus(403); // Lojista não pode transferir
        $response->assertJsonFragment([
            'message' => 'Shopkeepers are not allowed to transfer funds.',
        ]);
    }

    public function test_transfer_should_fail_if_insufficient_balance()
    {
        Http::fake([
            'https://util.devi.tools/api/v2/authorize' => Http::response([
                'status' => 'success',
                'data' => [
                    'authorization' => true
                ]
            ], 200),
        ]);

        $payer = User::factory()->create([
            'type' => 'common',
            'wallet_balance' => 20,
        ]);

        $payee = User::factory()->create([
            'type' => 'shopkeeper',
            'wallet_balance' => 0,
        ]);

        $response = $this->postJson('/api/transfer', [
            'payer' => $payer->id,
            'payee' => $payee->id,
            'value' => 100,
        ]);

        $response->assertStatus(422); // Saldo insuficiente
        $response->assertJsonFragment([
            'message' => 'Insufficient balance.',
        ]);
    }
}
