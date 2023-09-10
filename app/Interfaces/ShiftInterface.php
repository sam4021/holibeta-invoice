<?php

namespace App\Interfaces;

interface ShiftInterface
{

    public function getShift();
    public function createShift($data);
    public function updateShift($data, $id);
    public function deleteShift($id);
}
