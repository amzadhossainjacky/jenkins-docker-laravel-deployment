<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RoleModelSeeder;
use Database\Seeders\UserModelSeeder;
use Database\Seeders\PermissionModelSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            RoleModelSeeder::class,
            UserModelSeeder::class,
            PermissionModelSeeder::class,
        ]);
    }
}
