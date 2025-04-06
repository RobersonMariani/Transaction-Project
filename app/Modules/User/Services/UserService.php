<?php

namespace App\Modules\User\Services;

use App\Modules\User\DTOs\CreateUserDTO;
use App\Modules\User\Models\User;
use App\Modules\User\Repositories\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    public function create(CreateUserDTO $data): User
    {
        /** @var User $user */
        $user =   DB::transaction(function () use ($data): User {
            return $this->userRepository->create($data);
        });

        return $user;
    }

    /**
     * @return Collection<int, User>
     */
    public function all(): Collection
    {
        return $this->userRepository->all();
    }
}
