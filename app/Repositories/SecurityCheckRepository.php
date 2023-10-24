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
        $securityChecks=SecurityCheck::with(['product','shift','user','confirmBy','machine'])
            ->when(request('search'),function ($query){
                $query->whereHas('product', function ($q){
                    $q->where('name','like','%'.request('search').'%');
                });

            })
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
        return new SecurityCheckResource(SecurityCheck::findOrFail($id));
    }

    public function  createSecurityCheck($data){
        try {

            $securityCheck=SecurityCheck::create([
                'supplier_id'=>$data['supplier'], 
                'created_by'=>$data['created_by'], 
                'vehicle_reg_no'=>$data['vehicle_reg_no'], 
                'vehicle_id'=>$data['vehicle'], 
                'front_image'=>$data['front_image'], 
                'back_image'=>$data['back_image'], 
                'side_image'=>$data['side_image']
            ]);
            return response()->json(['message'=>'Security Check created successfully','securityCheck'=>$securityCheck],200);
        }catch (\Exception $exception){
            return response()->json(['message'=>$exception->getMessage()],400);
        }
    }

    public function updateSecurityCheck(array $data, string $id){
        try {

            $securityCheck=SecurityCheck::findOrFail($id);
            $securityCheck->update(
                [
                    'name'=>$data['name'],
                    'description'=>$data['description'],
                    'product_type_id'=>$data['product_type'],
                    'product_weight_id'=>$data['product_weight'],
                    'user_id'=>$data['user_id'],
                ]
            );
            return response()->json(['message'=>'Security Check updated successfully','securityCheck'=>$securityCheck],200);
        }catch (\Exception $exception){

            return response()->json(['message'=>$exception->getMessage()],400);
        }
    }

    public function deleteSecurityCheck(string $id)
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
