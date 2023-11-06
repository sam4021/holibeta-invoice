<?php

namespace App\Interfaces;

interface DriverInterface
{

    public function getDrivers();
    public function storeDriver($data);
    public function updateDriver($data, $id);
    public function deleteDriver($id);

}
