<?php

namespace App\Enums;

enum StatusEnum: string
{

    case Enabled='Enabled';
    case Disabled='Disabled';
    case Sold='Sold';
    case Retured='Returned';
    case InWarehouse='In Warehouse';
}
