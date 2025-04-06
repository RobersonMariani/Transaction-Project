<?php

namespace App\Modules\User\Repositories;

use App\Modules\User\DTOs\CreateUserDTO;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
    public function create(CreateUserDTO $data): User
    {
        /** @var User $user */
        $user = User::create([
            'name' => $data->name,
            'cpf' => $data->cpf,
            'email' => $data->email,
            'password' => bcrypt($data->password),
            'type' => $data->type,
        ]);

        return $user;
    }

    public function findById(int $id): ?User
    {
        /** @var User|null $user */
        $user = User::find($id);

        return $user;
    }

    /**
     * @return Collection<int, User>
     */
    public function all(): Collection
    {
        /** @var Collection<int, User> $users */
        $users = User::all();

        return $users;
    }
}
