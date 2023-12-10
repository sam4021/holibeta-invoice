<?php

namespace App\Enums;

enum RoleEnum: string
{
    case Admin = 'Admin';
    case SecuritySupervisor = 'Security Supervisor';
    case StoreManager = 'Store Manager';
    case StoreOfficer = 'Store Officer';
    case StoreSupervisor = 'Store Supervisor';
    case GrainInspector = 'Grain Inspector';
    case LaboratorySupervisor = 'Laboratory Supervisor';
    case WeighbridgeOperator =  'Weighbridge Operator';
    case WeighbridgeSupervisor = 'Weighbridge Supervisor';
}
