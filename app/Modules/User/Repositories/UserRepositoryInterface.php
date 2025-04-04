<?php

namespace App\Modules\User\Repositories;

use App\Modules\User\DTOs\CreateUserDTO;
use App\Modules\User\Models\User;

interface UserRepositoryInterface
{
    public function create(CreateUserDTO $data): User;
    public function findById(int $id): ?User;
}
