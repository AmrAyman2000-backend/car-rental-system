<?php


namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
        ]);

        $users = [
            [
                'name' => 'amr ayman',
                'email' => 'amr@yahoo.com',
                'password' => Hash::make('147852369'),
                'role' => 'user',
            ],
            [
                'name' => 'omar khaled',
                'email' => 'omar@yahoo.com',
                'password' => Hash::make('963258741'),
                'role' => 'user',
            ],
            [
                'name' => 'Alice Johnson',
                'email' => 'alice@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
            ],
            [
                'name' => 'Bob Brown',
                'email' => 'bob@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}

