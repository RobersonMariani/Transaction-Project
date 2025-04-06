<?php

namespace App\Modules\User\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    /**
     * Autoriza o envio da requisição.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Regras de validação para criação de usuário.
     *
     * @return array<string, string>
     */
    public function rules(): array
    {
        return [
            'name'     => 'required|string|max:255',
            'cpf'      => 'required|string|max:14|unique:users,cpf',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'type'     => 'required|in:common,shopkeeper',
        ];
    }

    public function getName(): string
    {
        /** @var array{name: string} $validated */
        $validated = $this->validated();
        return $validated['name'];
    }

    public function getCpf(): string
    {
        /** @var array{cpf: string} $validated */
        $validated = $this->validated();
        return $validated['cpf'];
    }

    public function getEmail(): string
    {
        /** @var array{email: string} $validated */
        $validated = $this->validated();
        return $validated['email'];
    }

    public function getPassword(): string
    {
        /** @var array{password: string} $validated */
        $validated = $this->validated();
        return $validated['password'];
    }

    public function getType(): string
    {
        /** @var array{type: string} $validated */
        $validated = $this->validated();
        return $validated['type'];
    }
}
