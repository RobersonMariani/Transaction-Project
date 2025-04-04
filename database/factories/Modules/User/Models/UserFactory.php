<?php

namespace Database\Factories\Modules\User\Models;

use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'cpf' => $this->faker->unique()->numerify('###########'),
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'),
            'type' => $this->faker->randomElement(['common', 'shopkeeper']),
            'wallet_balance' => $this->faker->randomFloat(2, 10, 1000),
        ];
    }
}
