<?php

use Illuminate\Database\Seeder;

class TemperatureTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (($handle = fopen(public_path("raw/temperature-200901-201808.csv"), "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $date = explode('-', $data[0]);
                \App\Temperature::create([
                    'year' => $date[0],
                    'month' => $date[1],
                    'temperature' => $data[1],
                ]);
            }
            fclose($handle);
        }
    }
}
