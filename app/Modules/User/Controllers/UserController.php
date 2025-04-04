<?php

namespace App\Modules\User\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\User\Requests\CreateUserRequest;
use App\Modules\User\Services\UserService;
use App\Modules\User\DTOs\CreateUserDTO;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {}

    public function store(CreateUserRequest $request)
    {
        $dto = new CreateUserDTO(
            name: $request->name,
            cpf: $request->cpf,
            email: $request->email,
            password: $request->password,
            type: $request->type
        );

        $user = $this->userService->create($dto);

        return response()->json($user, 201);
    }
}
