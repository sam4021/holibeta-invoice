<?php

namespace App\Repositories\Transaction;

use App\Http\Resources\Transaction\TransactionResource;
use App\Interfaces\Transaction\TransactionInterface;
use App\Models\Transactions;
use App\Models\TransactionLineItems;
use App\Models\TransactionStatus;
use App\Models\TransactionVat;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Enums\StatusEnum;
use App\Enums\VatTypeEnum;

class TransactionRepository implements TransactionInterface
{

    public function getTransactions(){
        $transactions= Transactions::when(request('search'), function($query){
               $query->where('name','like','%'.request('search').'%');
           })
         ->paginate(request('showing')??10);
        return TransactionResource::collection($transactions);
    }

    public function getTransactionById($id)
    {
        $transaction =  Transactions::find($id);
        return new TransactionResource($transaction);
    }

    public function storeTransaction($data)
    {
        DB::beginTransaction();
        try {
            $transaction= Transactions::create([
                'reference' => $data['reference'],
                'transaction_type' => $data['transaction_type'],
                'narration' => $data['narration'],
                'created_by' => $data['created_by'],
                'customer_id' => $data['customer_id'],
                'order_id' => $data['order_id']
            ]);

            TransactionStatus::create([
                'transaction_id'=>$transaction->id,
                'status' =>StatusEnum::Pending->value,
            ]);

            TransactionLineItems::create([
                'transaction_id' => $transaction->id,
                'amount' => $data['amount'],
            ]);

            if($data['vat']){
                $vat = TransactionVat::find($data['vat']);
                if($vat->rate){
                    if ($vat->type == VatTypeEnum::Fixed) {
                        $vatAmount = $vat->rate;
                    } else {
                        $vatAmount = ($vat->rate * $data['amount'])/100;
                    }
                    if ($vatAmount) {
                        TransactionLineItems::create([
                            'transaction_id' => $transaction->id,
                            'amount' => $vatAmount,
                            'vat_inclusive' => 1,
                        ]);
                    }                    
                }           
            }

            DB::commit();
            return response()->json([
                'status'=>200,
                'message'=> 'Transaction created successfully',
                'transaction'=>new TransactionResource($transaction)
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
            return response()->json([
                'status'=>400,
                'message'=> 'Transaction creation failed',
                'error'=>$th->getMessage()
            ]);
        }
    }

    public function updateTransaction($data, $id){
        try {
            $transaction= Transactions::find($id);
            $transaction->update($data);
            return response()->json([
                'status'=>200,
                'message'=> 'Transaction updated successfully',
                'transaction'=>new TransactionResource($transaction)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'=>400,
                'message'=> 'Transaction update failed',
                'error'=>$th->getMessage()
            ]);
        }
    }

    public function deleteTransaction($id){
        try {
            $transaction= Transactions::findOrFail($id);
            $transaction->delete();
            return response()->json([
                'status'=>200,
                'message'=> 'Transaction deleted successfully',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'=>400,
                'message'=> 'Transaction deletion failed',
                'error'=>$th->getMessage()
            ]);
        }
    }
}
