<?php

namespace Database\Seeders;

use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $shifts=[
            [
                'name'=>'Shift 1',
                'start_time'=>'8:00:00',
                'end_time'=>'5:00:00'
            ],
            [
                'name'=>'Shift 2',
                'start_time'=>'5:00:01',
                'end_time'=>'11:00:00'
            ],
            [
                'name'=>'Shift 2',
                'start_time'=>'11:00:01',
                'end_time'=>'8:00:00'
            ]
        ];

        Schema::disableForeignKeyConstraints();
        Shift::truncate();
        Schema::enableForeignKeyConstraints();

        foreach ($shifts as $shift){
            Shift::create([
                'name'=>$shift['name'],
                'start_time'=>$shift['start_time'],
                'end_time'=>$shift['end_time']
            ]);
        }
    }
}
