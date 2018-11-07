<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AccidentTableSeeder::class);
        $this->call(RainfallTableSeeder::class);
        $this->call(TemperatureTableSeeder::class);
    }
}
