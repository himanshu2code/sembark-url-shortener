<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $users = [
            [
                'name' => 'Super Admin 1',
                'email' => 'superadmin1@example.com',
                'password' => Hash::make('ChangeMe@123'),
                'role' => 'SuperAdmin',
                'company_id' => null,
            ],
            [
                'name' => 'Super Admin 2',
                'email' => 'superadmin2@example.com',
                'password' => Hash::make('ChangeMe@456'),
                'role' => 'SuperAdmin',
                'company_id' => null,
            ],
        ];

        foreach ($users as $user) {
            $existingUser = DB::selectOne(
                'SELECT id FROM users WHERE email = ?',
                [$user['email']]
            );

            if ($existingUser !== null) {
                continue;
            }

            DB::insert(
                'INSERT INTO users
                    (name, email, password, role, company_id, created_at, updated_at)
                VALUES (?, ?, ?, ?, ?, ?, ?)',
                [
                    $user['name'],
                    $user['email'],
                    $user['password'],
                    $user['role'],
                    $user['company_id'],
                    $now,
                    $now,
                ]
            );
        }
    }
}
