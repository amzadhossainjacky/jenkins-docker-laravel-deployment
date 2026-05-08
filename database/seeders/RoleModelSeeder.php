<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'admin', 'route_segment' => 'admin'],
            ['name' => 'teacher', 'route_segment' => 'teacher'],
            ['name' => 'student', 'route_segment' => 'student'],
        ];

        foreach ($data as $item) {
            Role::create([
                'name' => $item['name'],
                'route_segment' => $item['route_segment'],
                'guard_name' => 'web',
                'is_active' => 1,
            ]);
        }
    }
}
