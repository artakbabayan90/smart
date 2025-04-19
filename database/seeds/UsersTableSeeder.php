<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Создание администратора
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'), // Захешированный пароль
            'role' => 'admin',
            'balance' => 0.00,
        ]);

        // Создание 10 обычных пользователей
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'name' => 'User ' . $i,
                'email' => 'user' . $i . '@example.com',
                'password' => bcrypt('password'), // Используем тот же пароль для простоты
                'role' => 'user',
                'balance' => rand(10, 100) / 10.0, // Случайный баланс от 1.00 до 10.00
            ]);
        }
    }
}
