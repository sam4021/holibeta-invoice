<?php

namespace App\Repositories\Transaction;

use App\Http\Resources\Transaction\VatResource;
use App\Interfaces\Transaction\VatInterface;
use App\Models\TransactionVat;
use Carbon\Carbon;

class VatRepository implements VatInterface
{

    public function getVats(){
        $vats= TransactionVat::when(request('search'), function($query){
               $query->where('name','like','%'.request('search').'%');
           })
         ->paginate(request('showing')??10);
        return VatResource::collection($vats);
    }

    public function getVatById($id)
    {
        $transaction =  TransactionVat::find($id);
        return new VatResource($transaction);
    }

    public function storeVat($data){
        try {
            $vat= TransactionVat::create([
                "name" => $data['name'],
                "rate" => $data['rate'],
                "type" => $data['type'],
                "created_by" => $data['created_by'],
            ]);
            return response()->json([
                'status'=>200,
                'message'=> 'Transaction Vat created successfully',
                'transaction'=>new VatResource($vat)
            ]);
        } catch (\Throwable $th) {
            dd($th);
            return response()->json([
                'status'=>400,
                'message'=> 'Transaction Vat creation failed',
                'error'=>$th->getMessage()
            ]);
        }
    }

    public function updateVat($data, $id){
        try {
            $vat= TransactionVat::find($id);
            $vat->update($data);
            return response()->json([
                'status'=>200,
                'message'=> 'Transaction Vat updated successfully',
                'transaction'=>new VatResource($vat)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'=>400,
                'message'=> 'Transaction Vat update failed',
                'error'=>$th->getMessage()
            ]);
        }
    }

    public function deleteVat($id){
        try {
            $vat= TransactionVat::findOrFail($id);
            $vat->delete();
            return response()->json([
                'status'=>200,
                'message'=> 'Transaction Vat deleted successfully',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'=>400,
                'message'=> 'Transaction Vat deletion failed',
                'error'=>$th->getMessage()
            ]);
        }
    }
}
