<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@hotel.com'],
            [
                'name'     => 'System Admin',
                'password' => bcrypt('password'),
            ]
        );
        $admin->assignRole('super_admin');

        $manager = User::firstOrCreate(
            ['email' => 'manager@hotel.com'],
            [
                'name'     => 'Hotel Manager',
                'password' => bcrypt('password'),
            ]
        );
        $manager->assignRole('manager');

        $receptionist = User::firstOrCreate(
            ['email' => 'reception@hotel.com'],
            [
                'name'     => 'Front Desk',
                'password' => bcrypt('password'),
            ]
        );
        $receptionist->assignRole('receptionist');

        $this->command->info('Admin users seeded successfully.');
    }
}