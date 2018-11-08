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
        // GPS data
        if (($handle = fopen(public_path("raw/accident-20180101-20180831.csv"), "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                \App\Accident::create([
                    'date' => $data[0],
                    'time' => $data[1],
                    'city' => $data[2],
                    'district' => $data[3],
                    'gps_longitude' => $data[4],
                    'gps_latitude' => $data[5],
                ]);
            }
            fclose($handle);
        }

        // No GPS data
        if (($handle = fopen(public_path("raw/accident-20130101-20171231.csv"), "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                \App\Accident::create([
                    'date' => $data[0],
                    'time' => $data[1],
                    'city' => $data[2],
                    'district' => $data[3],
                ]);
            }
            fclose($handle);
        }
    }
}
