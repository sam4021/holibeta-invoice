<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Schema::disableForeignKeyConstraints();
        Role::truncate();
        Schema::enableForeignKeyConstraints();

        $roles=[
            [
                'name'=>RoleEnum::Admin->value,
                'guard_name'=>'web'
            ],
            [
                'name'=>RoleEnum::Supervisor->value,
                'guard_name'=>'web'
            ],
            [
                'name'=>RoleEnum::MachineOperator->value,
                'guard_name'=>'web'
            ],
        ];

        foreach ($roles as $role){
            Role::create($role);
        }
    }
}
