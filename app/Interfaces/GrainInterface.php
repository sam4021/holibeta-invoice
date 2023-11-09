<?php

namespace App\Interfaces;

interface GrainInterface
{

    public function getGrains();
    public function storeGrain($data);
    public function updateGrain($data, $id);
    public function deleteGrain($id);
}
