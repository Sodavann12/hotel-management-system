<?php

namespace App\Services;

use App\Models\Room;

class PricingService
{
    public function calculate(Room $room, string $checkIn, string $checkOut): float
    {
        $nights    = now()->parse($checkIn)->diffInDays($checkOut);
        $basePrice = (float) $room->roomType->base_price;
        $total     = 0;
        $date      = now()->parse($checkIn);

        for ($i = 0; $i < $nights; $i++) {
            $nightPrice = $basePrice;
            // Weekend surcharge +20% on Friday and Saturday
            if (in_array($date->dayOfWeek, [5, 6])) {
                $nightPrice *= 1.20;
            }
            $total += $nightPrice;
            $date->addDay();
        }

        return round($total, 2);
    }
}