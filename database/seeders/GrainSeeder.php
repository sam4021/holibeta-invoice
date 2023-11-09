<?php

namespace Database\Seeders;

use App\Models\Grains;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class GrainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Schema::disableForeignKeyConstraints();
        Grains::truncate();
        Schema::enableForeignKeyConstraints();
        $grains=file_get_contents(public_path('data/grains.json'));
        $decoded_grains=json_decode($grains);
       foreach ($decoded_grains->data as $grain){
            Grains::create([
               'name'=> $grain->name,
           ]);
       }


    }
}
