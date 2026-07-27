<?php

namespace Database\Seeders;

use App\Models\Seat;
use App\Models\Venue;
use Illuminate\Database\Seeder;

class SeatSeeder extends Seeder
{
    public function run()
    {
        $venues = Venue::all();

        foreach ($venues as $venue) {
            // 10 satır (A-J) ve 10 sütun (1-10)
            $rows = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
            $seatsPerRow = 10; // Her satırda 10 koltuk

            // Kapasite kontrolü: eğer salon 100'den küçükse, o kadar koltuk oluştur
            $totalSeats = $venue->capacity;
            $seatCount = 0;

            for ($i = 0; $i < count($rows); $i++) {
                for ($j = 1; $j <= $seatsPerRow; $j++) {
                    $seatCount++;
                    if ($seatCount > $totalSeats) {
                        break 2; // Kapasite dolduysa tüm döngülerden çık
                    }

                    Seat::firstOrCreate(
                        ['code' => $rows[$i] . $j],
                        [
                            'venue_id' => $venue->id,
                            'row' => $rows[$i],
                            'number' => $j,
                            'section' => null,
                            'is_active' => true,
                        ]
                    );
                }
            }
        }
    }
}
