<?php

namespace App\Repositories;

use App\Enums\ConfirmStatusEnum;
use App\Http\Resources\WeighbridgeResource;
use App\Interfaces\WeighbridgeInterface;
use App\Models\Weighbridge;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WeighbridgeRepository implements WeighbridgeInterface
{

    public function getWeighbridges()
    {
        $weighbridges = Weighbridge::with(['delivery', 'supplier', 'createdBy'])
            ->paginate(request('showing') ?? 10);

        return WeighbridgeResource::collection($weighbridges);
    }

    public function getAllWeighbridges()
    {
        $weighbridges = Weighbridge::with(['delivery', 'supplier', 'createdBy'])
            ->get();

        return WeighbridgeResource::collection($weighbridges);
    }

    public function getEmptyWeighbridges()
    {
        $weighbridges = Weighbridge::doesntHave('qualityControl')
            ->get();

        return WeighbridgeResource::collection($weighbridges);
    }

    public function getDelivery()
    {
        $weighbridges = DB::table('weighbridges')
                        ->join('security_checks','security_checks.id','weighbridges.delivery_id')
                        ->select('weighbridges.id', DB::raw('CONCAT(security_checks.vehicle_reg_no, " :: " , security_checks.security_check_code) AS name'))
                        ->get()->toArray();
        return $weighbridges;
    }

    public function getWeighbridgeById(string $id)
    {
        return new WeighbridgeResource(Weighbridge::with(['delivery', 'supplier', 'createdBy'])->findOrFail($id));
    }

    public function  createWeighbridge($data)
    {
        try {
            $weighbridge = Weighbridge::create([
                'delivery_id' => $data['delivery'],
                'created_by' => $data['created_by'],
                'weight' => $data['weight'],
                'image' => $data['image'],
                'supplier_id' => $data['supplier'],
            ]);
            return response()->json(['message' => 'Weighbridge created successfully', 'weighbridge' => $weighbridge], 200);
        } catch (\Exception $exception) {
            dd($exception->getMessage());
            return response()->json(['message' => $exception->getMessage()], 400);
        }
    }

    public function updateWeighbridge(array $data, string $id)
    {
        try {
            $weighbridge = Weighbridge::findOrFail($id);
            $weighbridge->update(
                [
                    'delivery_id' => $data['delivery'],
                    'weight' => $data['weight'],
                    'supplier_id' => $data['supplier']
                ]
            );
            return response()->json(['message' => 'Weighbridge updated successfully', 'weighbridge' => $weighbridge], 200);
        } catch (\Exception $exception) {
            dd($exception->getMessage());
            return response()->json(['message' => $exception->getMessage()], 400);
        }
    }

    public function deleteWeighbridge(int $id)
    {

        try {
            $weighbridge = Weighbridge::findOrFail($id);
            $weighbridge->delete();
            return response()->json(['message' => 'Weighbridge deleted'], 200);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 400);
        }
    }
}
