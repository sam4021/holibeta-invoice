<?php

namespace Database\Seeders;

use App\Models\County;
use App\Models\Subcounty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CountySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        County::truncate();
        Schema::enableForeignKeyConstraints();
        $counties=file_get_contents(public_path('data/counties.json'));
        $decoded_counties=json_decode($counties);
       foreach ($decoded_counties as $county){
            $countyData=County::create([
               'name'=> $county->name,
           ]);
           foreach ($county->sub_counties as $value) {
                Subcounty::create([
                'name'=> $value,
                    'county_id'=> $countyData->id
            ]);
           }
       }


    }
}
