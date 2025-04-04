<?php

namespace Tests\Feature\Modules\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Modules\User\Models\User;

class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_user_successfully()
    {
        $payload = [
            'name' => 'Roberson Silva',
            'cpf' => '12345678901',
            'email' => 'roberson@example.com',
            'password' => '12345678',
            'type' => 'common',
        ];

        $response = $this->postJson('/api/users', $payload);

        $response->assertStatus(201)
            ->assertJsonFragment([
                'name' => $payload['name'],
                'cpf' => $payload['cpf'],
                'email' => $payload['email'],
                'type' => $payload['type'],
            ]);

        $this->assertDatabaseHas('users', [
            'email' => $payload['email'],
            'cpf' => $payload['cpf'],
            'type' => $payload['type'],
        ]);
    }

    public function test_cannot_create_user_with_duplicate_email()
    {
        $existing = User::factory()->create([
            'email' => 'duplicado@example.com',
            'cpf' => '00000000000',
        ]);

        $payload = [
            'name' => 'Outro Roberson',
            'cpf' => '11111111111',
            'email' => 'duplicado@example.com',
            'password' => 'senha123',
            'type' => 'common',
        ];

        $response = $this->postJson('/api/users', $payload);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }

    public function test_cannot_create_user_with_duplicate_cpf()
    {
        $existing = User::factory()->create([
            'email' => 'unico@example.com',
            'cpf' => '99999999999',
        ]);

        $payload = [
            'name' => 'Roberson Clonado',
            'cpf' => '99999999999',
            'email' => 'outro@example.com',
            'password' => 'senha123',
            'type' => 'shopkeeper',
        ];

        $response = $this->postJson('/api/users', $payload);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['cpf']);
    }
}
