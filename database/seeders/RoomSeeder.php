<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;
use App\Models\RoomType;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $standard  = RoomType::where('name', 'Standard Room')->first();
        $deluxe    = RoomType::where('name', 'Deluxe Room')->first();
        $junior    = RoomType::where('name', 'Junior Suite')->first();
        $executive = RoomType::where('name', 'Executive Suite')->first();

        $rooms = [
            // Floor 1 — Standard
            ['number' => '101', 'floor' => 1, 'room_type_id' => $standard->id],
            ['number' => '102', 'floor' => 1, 'room_type_id' => $standard->id],
            ['number' => '103', 'floor' => 1, 'room_type_id' => $standard->id],
            ['number' => '104', 'floor' => 1, 'room_type_id' => $standard->id],
            // Floor 2 — Deluxe
            ['number' => '201', 'floor' => 2, 'room_type_id' => $deluxe->id],
            ['number' => '202', 'floor' => 2, 'room_type_id' => $deluxe->id],
            ['number' => '203', 'floor' => 2, 'room_type_id' => $deluxe->id],
            // Floor 3 — Junior Suites
            ['number' => '301', 'floor' => 3, 'room_type_id' => $junior->id],
            ['number' => '302', 'floor' => 3, 'room_type_id' => $junior->id],
            // Floor 4 — Executive Suites
            ['number' => '401', 'floor' => 4, 'room_type_id' => $executive->id],
            ['number' => '402', 'floor' => 4, 'room_type_id' => $executive->id],
        ];

        foreach ($rooms as $room) {
            Room::firstOrCreate(['number' => $room['number']], $room);
        }

        $this->command->info('Rooms seeded successfully.');
    }
}