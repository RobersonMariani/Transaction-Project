<?php

namespace App\Modules\User\DTOs;

class CreateUserDTO
{
    /**
     * DTO responsável por carregar os dados de um usuário.
     */
    public function __construct(
        public string $name,
        public string $cpf,
        public string $email,
        public string $password,
        public string $type
    ) {}
}
