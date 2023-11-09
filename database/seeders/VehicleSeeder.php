<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Schema::disableForeignKeyConstraints();
        Vehicle::truncate();
        Schema::enableForeignKeyConstraints();
        $vehicles=file_get_contents(public_path('data/vehicles.json'));
        $decoded_vehicles=json_decode($vehicles);
       foreach ($decoded_vehicles->data as $vehicle){
            Vehicle::create([
               'name'=> $vehicle->name,
           ]);
       }


    }
}
