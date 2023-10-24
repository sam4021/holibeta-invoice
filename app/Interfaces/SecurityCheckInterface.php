<?php

namespace App\Interfaces;

interface SecurityCheckInterface
{

    public function getSecurityChecks();
    public function getSecurityCheckById(string $id);
    public function createSecurityCheck(array $data);
    public function updateSecurityCheck(array $data, string $id);
    public function deleteSecurityCheck($id);

}
