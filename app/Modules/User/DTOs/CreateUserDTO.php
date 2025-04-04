<?php

namespace App\Modules\User\DTOs;

class CreateUserDTO
{
    public function __construct(
        public string $name,
        public string $cpf,
        public string $email,
        public string $password,
        public string $type
    ) {}
}
