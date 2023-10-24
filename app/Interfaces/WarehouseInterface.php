<?php

namespace App\Interfaces;

interface WarehouseInterface
{

    public function getWarehouses();
    public function getWarehouseById(string $id);
    public function createWarehouse(array $data);
    public function updateWarehouse(array $data, string $id);
    public function deleteWarehouse(int $id);

}
