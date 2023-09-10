<?php

namespace App\Enums;

enum ConfirmStatusEnum:string
{

    case Pending = 'Pending';
    case Confirmed = 'Confirmed';
    case Rejected = 'Rejected';
}
