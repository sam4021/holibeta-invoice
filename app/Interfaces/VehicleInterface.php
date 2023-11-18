<?php

namespace App\Interfaces;

interface VehicleInterface
{

    public function getVehicles();
    public function getAllVehicles();
    public function storeVehicle($data);
    public function updateVehicle($data, $id);
    public function deleteVehicle($id);

}
