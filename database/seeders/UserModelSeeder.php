<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = '12345678';
        $users = [
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make($password),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        foreach ($users as $key => $user) {
            $user = User::create($user);
            $user->assignRole(1);
        }

        $users2 = [
            [
                'name' => 'teacher',
                'email' => 'teacher@gmail.com',
                'password' => Hash::make($password),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];


        foreach ($users2 as $key => $user) {
            $user = User::create($user);
            $user->assignRole(2);
        }

        $users3 = [
            [
                'name' => 'student',
                'email' => 'student@gmail.com',
                'password' => Hash::make($password),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];


        foreach ($users3 as $key => $user) {
            $user = User::create($user);
            $user->assignRole(3);
        }
    }
}
