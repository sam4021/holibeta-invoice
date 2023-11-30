<?php

namespace App\Enums;

enum VehicleTypeEnum: string
{
    case LGV = 'LGV'; 
    case MGV = 'MGV';
    case TwoAxleHGV = '2 Axle HGV'; 
    case Three3AxleHGV = '3 Axle HGV'; 
    case FourAxleHGV = '4 Axle HGV'; 
    case FiveAxleHGV = '5 Axle HGV'; 
    case SixAxleHGV = '6 Axle HGV'; 
    case Other = 'Other';
}
