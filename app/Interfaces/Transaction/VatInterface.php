<?php

namespace App\Interfaces\Transaction;

interface VatInterface
{

    public function getVats();
    public function getVatById($id);
    public function storeVat($data);
    public function updateVat($data, $id);
    public function deleteVat($id);
}
