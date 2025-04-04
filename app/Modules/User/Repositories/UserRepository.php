<?php

namespace App\Modules\User\Repositories;

use App\Modules\User\DTOs\CreateUserDTO;
use App\Modules\User\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function create(CreateUserDTO $data): User
    {
        return User::create([
            'name' => $data->name,
            'cpf' => $data->cpf,
            'email' => $data->email,
            'password' => bcrypt($data->password),
            'type' => $data->type,
        ]);
    }

    public function findById(int $id): ?User
    {
        return User::find($id);
    }
}
