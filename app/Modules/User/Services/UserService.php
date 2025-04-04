<?php

namespace App\Modules\User\Services;

use App\Modules\User\DTOs\CreateUserDTO;
use App\Modules\User\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    public function create(CreateUserDTO $data)
    {
        return DB::transaction(function () use ($data) {
            return $this->userRepository->create($data);
        });
    }
}
