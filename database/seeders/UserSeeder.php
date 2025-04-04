<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\User\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Usuário comum (pode enviar)
        User::create([
            'name' => 'Usuário Comum',
            'cpf' => '11111111111',
            'email' => 'comum@picpay.com',
            'password' => bcrypt('senha123'),
            'type' => 'common',
            'wallet_balance' => 1000,
        ]);

        // Lojista (só pode receber)
        User::create([
            'name' => 'Lojista',
            'cpf' => '22222222222',
            'email' => 'lojista@picpay.com',
            'password' => bcrypt('senha123'),
            'type' => 'shopkeeper',
            'wallet_balance' => 1000,
        ]);
    }
}
