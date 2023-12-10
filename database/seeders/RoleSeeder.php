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
                'name'=>RoleEnum::SecuritySupervisor->value,
                'guard_name'=>'web'
            ],
            [
                'name'=>RoleEnum::StoreManager->value,
                'guard_name'=>'web'
            ],
            [
                'name' => RoleEnum::StoreOfficer->value,
                'guard_name' => 'web'
            ],
            [
                'name' => RoleEnum::StoreSupervisor->value,
                'guard_name' => 'web'
            ],
            [
                'name' => RoleEnum::GrainInspector->value,
                'guard_name' => 'web'
            ],
            [
                'name' => RoleEnum::LaboratorySupervisor->value,
                'guard_name' => 'web'
            ],
            [
                'name' => RoleEnum::WeighbridgeOperator->value,
                'guard_name' => 'web'
            ],
            [
                'name' => RoleEnum::WeighbridgeSupervisor->value,
                'guard_name' => 'web'
            ],
        ];

        foreach ($roles as $role){
            Role::create($role);
        }
    }
}
