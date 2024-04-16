<?php

namespace App\Http\Controllers\Admin;

use File;
use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Interfaces\Transaction\TransactionInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Enums\RoleEnum;
use App\Enums\TransactionTypeEnum;
use Illuminate\Support\Facades\Auth;

class AdminTransactionController extends Controller
{
    private TransactionInterface $transactionRepository;
   

    public function __construct(TransactionInterface $transactionRepository){
        $this->transactionRepository= $transactionRepository;
        $this->middleware(['role:'.RoleEnum::Admin->value]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions=$this->transactionRepository->getTransactions();
        $filters = request()->all('search', 'showing');
        return inertia::render('admin/transaction/transactions/index', compact('transactions','filters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = TransactionTypeEnum::cases();
        return inertia::render('admin/transaction/transactions/create',compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated=$request->validate([
            'transaction_type'=>'required|string',
            'order'=>'nullable',
            'amount'=>'required',
        ]);
        $validated['created_by'] = Auth::user()->id;
        
        $transaction=$this->transactionRepository->storeTransaction($validated);

        if ($transaction->status()==200) {
            return redirect()->back()->with('success', 'Transaction created successfully');
        } else {
            return redirect()->back()->with('status', 'Transaction creation failed');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transaction = $this->transactionRepository->getTransactionById($id);
        return inertia::render('admin/transaction/transactions/show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $transaction = $this->transactionRepository->getTransactionById($id);
        return inertia::render('admin/transaction/transactions/edit', compact('transaction'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validated=$request->validate([
            'firstname'=>'required|string|max:20',
            'middlename'=>'nullable|string|max:20',
            'lastname'=>'required|string|max:20',
            'id_no'=>'required|string|max:125'
        ]);
        $transaction=$this->transactionRepository->updateTransaction($validated,$id);
        if ($transaction['status']==200) {
            return redirect()->back()->with('success', $transaction['message']);
        } else {
            return redirect()->back()->with('status', $transaction['message']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //

        $transaction=$this->transactionRepository->deleteTransaction($id);
        if ($transaction->status()==200) {
            return redirect()->back()->with('success', 'Transaction deleted successfully');
        } else {
            return redirect()->back()->with('status', 'Transaction deletion failed');
        }
    }
}
