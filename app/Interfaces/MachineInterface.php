<?php

namespace App\Interfaces;

interface MachineInterface
{

    public function getMachines();
    public function storeMachine($data);
    public function updateMachine($data, $id);
    public function machineDelete($id);

}
