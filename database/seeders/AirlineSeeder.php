<?php

namespace Database\Seeders;

use App\Models\Airline;
use Illuminate\Database\Seeder;

class AirlineSeeder extends Seeder
{
    public function run()
    {
        $airlines = [
            ['name' => 'Buddha Air', 'code' => 'BA', 'logo' => 'Buddha.png'],
            ['name' => 'Guna Airlines', 'code' => 'GA', 'logo' => 'guna.jpg'],
            ['name' => 'Yeti Airlines', 'code' => 'YA', 'logo' => 'Yeti.png'],
            ['name' => 'Himalaya Airlines ', 'code' => 'HA', 'logo' => 'Himalaya.png'],
            ['name' => 'Tara Air', 'code' => 'TA', 'logo' => 'Tara_Air_logo.png'],
            ['name' => 'Nepal Airlines ', 'code' => 'FZ', 'logo' => 'Nepal_Airlines_logo.png'],
        ];

        foreach ($airlines as $item) {
            $airline = Airline::create([
                'name' => $item['name'],
                'code' => $item['code'],
            ]);

            $path = "/assets/images/Airline logos/" . $item['logo'];
            $airline->addMedia(public_path() . $path)->preservingOriginal()->usingName($airline->name)->toMediaCollection();

            // PlaneSeeder
            $planes = [];
            foreach (range(1, rand(1, 4)) as $key => $value) {
                $planes[] = [
                    'name' => "Boeing 737-" . rand(100, 900),
                    'code' => "B" . rand(730, 739),
                    'capacity' => rand(150, 200),
                ];
            }

            $airline->planes()->createMany($planes);
        }
    }
}
