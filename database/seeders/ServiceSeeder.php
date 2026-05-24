<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name'        => 'Room Service',
                'description' => '24/7 in-room dining service.',
                'price'       => 15.00,
                'category'    => 'food_beverage',
            ],
            [
                'name'        => 'Breakfast Buffet',
                'description' => 'Full breakfast buffet per person.',
                'price'       => 20.00,
                'category'    => 'food_beverage',
            ],
            [
                'name'        => 'Airport Transfer',
                'description' => 'One-way airport pickup or drop-off.',
                'price'       => 35.00,
                'category'    => 'transport',
            ],
            [
                'name'        => 'Spa Treatment',
                'description' => '60-minute full body massage.',
                'price'       => 80.00,
                'category'    => 'spa',
            ],
            [
                'name'        => 'Laundry Service',
                'description' => 'Per bag laundry and ironing.',
                'price'       => 25.00,
                'category'    => 'laundry',
            ],
            [
                'name'        => 'Swimming Pool Access',
                'description' => 'Full day pool access per person.',
                'price'       => 10.00,
                'category'    => 'recreation',
            ],
        ];

        foreach ($services as $service) {
            Service::firstOrCreate(['name' => $service['name']], $service);
        }

        $this->command->info('Services seeded successfully.');
    }
}