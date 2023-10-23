<?php

namespace App\Enums;

enum RoleEnum: string
{
    case Admin = 'Admin';
    case Supplier = 'Supplier';
    case Customer = 'Customer';
    case Security = 'Security';
    case Warehouse = 'Warehouse';
    case Weighbridge = 'Weighbridge';
}
