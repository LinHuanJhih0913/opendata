<?php

use Illuminate\Database\Seeder;

class AccidentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (($handle = fopen(public_path("raw/accident-201801-201807.csv"), "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                \App\Accident::create([
                    'year' => $data[2],
                    'month' => $data[3],
                    'day' => (int)substr($data[0], -2),
                    'city' => $data[6],
                    'district' => $data[7],
                    'gps_longitude' => $data[4],
                    'gps_latitude' => $data[5],
//                    'time'=> $data[1],
                ]);
            }
            fclose($handle);
        }
    }
}
