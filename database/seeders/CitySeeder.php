<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    public function run()
    {
        $cities = [
            "Kathmandu KTM",
            "Everest Experience MTN",
            "Bhadrapur (Jhapa) BDP",
            "Bhairahawa BWA",
            "Bharatpur (Chitwan) BWA",
            "Biratnagar BIR",
            "Dhangadhi DHI",
            "Janakpur JKR",
            "Nepalgunj KEP",
            "Pokhara PKR",
            "Surkhet SKH",
            "Tumlingtar TMI",
        ];

        foreach ($cities as $city) {
            City::create([
                'name' => $city,
            ]);
        }
    }
}
