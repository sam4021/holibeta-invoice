<?php

namespace App\Interfaces;

interface WeighbridgeInterface
{

    public function getWeighbridges();
    public function getWeighbridgeById(string $id);
    public function createWeighbridge(array $data);
    public function updateWeighbridge(array $data, string $id);
    public function deleteWeighbridge(int $id);
}
