<?php

namespace App\Modules\User\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\User\Requests\CreateUserRequest;
use App\Modules\User\Services\UserService;
use App\Modules\User\DTOs\CreateUserDTO;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {}

    public function index(): JsonResponse
    {
        $users = $this->userService->all();

        return response()->json($users);
    }

    public function store(CreateUserRequest $request): JsonResponse
    {
        $dto = new CreateUserDTO(
            name: $request->getName(),
            email: $request->getEmail(),
            cpf: $request->getCpf(),
            password: $request->getPassword(),
            type: $request->getType(),
        );

        $user = $this->userService->create($dto);

        return response()->json([
            'message' => 'User Created Successfully.',
            'data' => $user
        ], 201);
    }
}
