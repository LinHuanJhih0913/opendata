<?php

use Illuminate\Database\Seeder;

class RainTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (($handle = fopen(public_path("raw/rain-201801-201807.csv"), "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                \App\Rain::create([
                    'year' => $data[0],
                    'month' => $data[1],
                    'day' => $data[2],
                    'rain_rate' => $data[3]
                ]);
            }
            fclose($handle);
        }
    }
}
