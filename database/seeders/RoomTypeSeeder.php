<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoomType;

class RoomTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'name'          => 'Standard Room',
                'description'   => 'Comfortable room with essential amenities.',
                'base_price'    => 80.00,
                'max_occupancy' => 2,
                'amenities'     => ['WiFi', 'AC', 'TV', 'Private Bathroom'],
            ],
            [
                'name'          => 'Deluxe Room',
                'description'   => 'Spacious room with premium furnishings.',
                'base_price'    => 130.00,
                'max_occupancy' => 2,
                'amenities'     => ['WiFi', 'AC', 'TV', 'Mini Bar', 'City View'],
            ],
            [
                'name'          => 'Junior Suite',
                'description'   => 'Suite with separate living area.',
                'base_price'    => 200.00,
                'max_occupancy' => 3,
                'amenities'     => ['WiFi', 'AC', 'Smart TV', 'Mini Bar', 'Bathtub', 'Lounge Area'],
            ],
            [
                'name'          => 'Executive Suite',
                'description'   => 'Luxury suite with panoramic views.',
                'base_price'    => 350.00,
                'max_occupancy' => 4,
                'amenities'     => ['WiFi', 'AC', 'Smart TV', 'Full Bar', 'Jacuzzi', 'Butler Service'],
            ],
        ];

        foreach ($types as $type) {
            RoomType::firstOrCreate(['name' => $type['name']], $type);
        }

        $this->command->info('Room types seeded successfully.');
    }
}