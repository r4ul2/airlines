<?php

namespace Database\Seeders;

use App\Models\Airport;
use App\Models\Zone;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
    
     
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            AirlineSeeder::class,
            CitySeeder::class,
            AirportSeeder::class,
            FlightSeeder::class,
        ]);
    }
}
