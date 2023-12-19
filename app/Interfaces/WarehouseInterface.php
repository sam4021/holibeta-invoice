<?php

namespace App\Interfaces;

interface WarehouseInterface
{

    public function getWarehouses();
    public function getWarehouseById(string $id);
    public function createWarehouse(array $data);
    public function updateWarehouse(array $data, string $id);
    public function deleteWarehouse(int $id);
    public function getWarehouseBags();
    public function getWarehouseBag(int $id);
    public function createStatus(int $id, string $status, int $user);
    public function getUniqueGrains();
    public function addWarehouseBags($id, $data);
}
