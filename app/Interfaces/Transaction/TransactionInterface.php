<?php

namespace App\Interfaces\Transaction;

interface TransactionInterface
{

    public function getTransactions();
    public function getTransactionById($id);
    public function storeTransaction($data);
    public function updateTransaction($data, $id);
    public function deleteTransaction($id);
}
