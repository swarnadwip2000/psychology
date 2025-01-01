<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Seeder;

class CountryStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $country = new Country();
        $country->name = 'Canada';
        $country->save();

        $states = [
            'Toronto',
            'Montreal'
        ];

        foreach ($states as $key => $value) {
            $city = new City();
            $city->name = $value;
            $city->country_id = $country->id;
            $city->save();
        }
    }
}
