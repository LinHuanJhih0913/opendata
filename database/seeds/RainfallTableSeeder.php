<?php

use Illuminate\Database\Seeder;

class RainfallTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (($handle = fopen(public_path("raw/rainfall-20120101-20180939.csv"), "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                \App\Rainfall::create([
                    'date' => $data[0],
                    'rainfall' => $data[1],
                ]);
            }
            fclose($handle);
        }
    }
}
