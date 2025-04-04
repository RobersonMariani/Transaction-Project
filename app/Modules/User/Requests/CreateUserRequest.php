<?php

namespace App\Modules\User\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'cpf' => 'required|string|max:14|unique:users,cpf',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'type' => 'required|in:common,shopkeeper',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
