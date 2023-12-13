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
        $securityChecks=SecurityCheck::with(['supplier', 'createdBy'])
            ->when(request('shift'),function ($query){
                $query->where('shift_id',request('shift'));
            })
            ->when(request('machine'),function ($query){
                $query->where('machine_id',request('machine'));
            })
            ->paginate(request('showing')??10);

        return SecurityCheckResource::collection($securityChecks);
    }


    public function getEmptySecurityChecks()
    {
        $securityChecks=SecurityCheck::with(['supplier', 'createdBy'])
            ->doesntHave('weighbridge')
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
        return new SecurityCheckResource(SecurityCheck::with(['supplier', 'createdBy'])->findOrFail($id));
    }

    public function  createSecurityCheck($data){
        try {          

            $securityCheck=SecurityCheck::create([
                'supplier_id'=>$data['supplier'], 
                'created_by'=>$data['created_by'], 
                'vehicle_reg_no'=>$data['stepOne']['vehicle_reg_no'],
                'vehicle_type'=>$data['stepOne']['vehicle_type'],
                'front_image'=>$data['front_image'], 
                'back_image'=>$data['back_image'], 
                'side_image'=>$data['side_image'],
                'top_image'=>$data['top_image'],
                'driver_id'=> $data['stepOne']['driver'],
                'timeslot'=>$data['stepOne']['timeslot'],
                'county_id' => $data['county'],
                'subcounty_id' => $data['subcounty']
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
                    'created_by' => $data['created_by'],
                    'vehicle_reg_no' => $data['vehicle_reg_no'],
                    'vehicle_type' => $data['vehicle_type'],
                    // 'front_image' => $data['front_image'],
                    // 'back_image' => $data['back_image'],
                    // 'side_image' => $data['side_image'],
                    // 'top_image' => $data['top_image'],
                    // 'driver_id' => $data['driver'],
                    'timeslot' => $data['timeslot']
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
