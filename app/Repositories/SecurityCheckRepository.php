<?php

namespace App\Repositories;

use App\Enums\ConfirmStatusEnum;
use App\Http\Resources\SecurityCheckResource;
use App\Interfaces\SecurityCheckInterface;
use App\Models\Product;
use App\Models\SecurityCheck;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SecurityCheckRepository implements SecurityCheckInterface
{

    public function getSecurityChecks(){
        $securityChecks=SecurityCheck::with(['supplier', 'createdBy', 'vehicle'])
            ->when(request('shift'),function ($query){
                $query->where('shift_id',request('shift'));
            })
            ->when(request('machine'),function ($query){
                $query->where('machine_id',request('machine'));
            })
            ->paginate(request('showing')??10);

        return SecurityCheckResource::collection($securityChecks);
    }

    public function getSecurityCheckById(string $id){
        return new SecurityCheckResource(SecurityCheck::with(['supplier', 'createdBy', 'vehicle'])->findOrFail($id));
    }

    public function  createSecurityCheck($data){
        try {
            $securityCheck=SecurityCheck::create([
                'supplier_id'=>$data['stepOne']['supplier'], 
                'created_by'=>$data['created_by'], 
                'vehicle_reg_no'=>$data['stepOne']['vehicle_reg_no'], 
                'vehicle_id'=>$data['stepOne']['vehicle'], 
                'front_image'=>$data['front_image'], 
                'back_image'=>$data['back_image'], 
                'side_image'=>$data['side_image'],
                'driver'=>$data['driver'],
                'timeslot'=>$data['stepOne']['timeslot']
            ]);
            return response()->json(['message'=>'Security Check created successfully','securityCheck'=>$securityCheck],200);
        }catch (\Exception $exception){
            dd($exception);
            return response()->json(['message'=>$exception->getMessage()],400);
        }
    }

    public function updateSecurityCheck(array $data, string $id){
        try {

            $securityCheck=SecurityCheck::findOrFail($id);
            $securityCheck->update(
                [
                    'supplier_id' => $data['supplier'],
                    'vehicle_reg_no' => $data['vehicle_reg_no'],
                    'vehicle_id' => $data['vehicle'],
                    // 'front_image' => $data['front_image'],
                    // 'back_image' => $data['back_image'],
                    // 'side_image' => $data['side_image']
                ]
            );
            return response()->json(['message'=>'Security Check updated successfully','securityCheck'=>$securityCheck],200);
        }catch (\Exception $exception){
dd($exception->getMessage());
            return response()->json(['message'=>$exception->getMessage()],400);
        }
    }

    public function deleteSecurityCheck(int $id)
    {

        try {
            $securityCheck=SecurityCheck::findOrFail($id);
            $securityCheck->delete();
            return response()->json(['message'=>'Security Check deleted'],200);
        }catch (\Exception $exception){
            return response()->json(['message'=>$exception->getMessage()],400);
        }
    }

}
