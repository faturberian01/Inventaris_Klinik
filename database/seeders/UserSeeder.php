<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory()->create([
            "name" => "Admin",
            "email" => "admin@gmail.com",
            'role' => UserRole::ADMIN,
        ]);

        $user2 = User::factory()->create([
            "name" => "Employee",
            "email" => "employee@gmail.com",
            'role' => UserRole::EMPLOYEE,
        ]);

        $user2 = User::factory()->create([
            "name" => "Me",
            "email" => "muhammadpauzi.dev@gmail.com",
            'role' => UserRole::ADMIN,
        ]);
    }
}
