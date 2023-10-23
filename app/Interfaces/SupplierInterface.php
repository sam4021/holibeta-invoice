<?php

namespace App\Interfaces;

interface SupplierInterface
{

    public function getSuppliers();
    public function createSupplier(array $data);
    public function updateSupplier(array $data, string $id);
    public function deleteSupplier($id);

}
