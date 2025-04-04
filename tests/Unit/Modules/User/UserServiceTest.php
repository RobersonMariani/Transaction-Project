<?php

namespace Tests\Unit\Modules\User;

use App\Modules\User\DTOs\CreateUserDTO;
use App\Modules\User\Models\User;
use App\Modules\User\Repositories\UserRepositoryInterface;
use App\Modules\User\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Mockery;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    public function test_can_create_user()
    {
        $dto = new CreateUserDTO(
            name: 'Roberson Test',
            cpf: '12345678901',
            email: 'roberson@example.com',
            password: 'secret123',
            type: 'common'
        );

        $mockRepo = Mockery::mock(UserRepositoryInterface::class);
        $mockRepo->shouldReceive('create')
            ->once()
            ->withArgs(function ($receivedDto) use ($dto) {
                return $receivedDto->email === $dto->email;
            })
            ->andReturn(new User([
                'id' => 1,
                'name' => $dto->name,
                'cpf' => $dto->cpf,
                'email' => $dto->email,
                'type' => $dto->type,
                'wallet_balance' => 0,
            ]));

        DB::shouldReceive('transaction')
            ->andReturnUsing(fn($callback) => $callback());

        $service = new UserService($mockRepo);
        $user = $service->create($dto);

        $this->assertEquals('roberson@example.com', $user->email);
    }
}
