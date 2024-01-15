<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Schema::disableForeignKeyConstraints();
        Country::truncate();
        Schema::enableForeignKeyConstraints();
        $countries=file_get_contents(public_path('data/countries.json'));
        $decoded_countries=json_decode($countries);
        //dd($decoded_countries);
       foreach ($decoded_countries->data as $country){

           Country::create([
               'name'=>$country->name,
               'code'=>$country->code,
               'dial_code'=>$country->dial_code,
               'flag'=>$country->flag,
               'currency_name'=>$country->currency_name,
               'currency_code'=>$country->currency_code
           ]);
       }


    }
}
