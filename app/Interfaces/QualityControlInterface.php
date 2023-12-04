<?php

namespace App\Interfaces;

interface QualityControlInterface
{

    public function getQualityControls();
    public function getAllQualityControls();
    public function createQualityControl(array $data);
    public function updateQualityControl(array $data, string $id);
    public function deleteQualityControl(int $id);
}
