<?php

namespace App\Interfaces;

interface DriverInterface
{

    public function getDrivers();
    public function getDriverById($id);
    public function storeDriver($data);
    public function updateDriver($data, $id);
    public function deleteDriver($id);
    public function getDriversCount();
}
