<?php

namespace App\Enums;

enum CategoryType: string
{
    case SHIPPING = 'Remessa';
    case PARTIAL_SHIPMENT = 'Remessa Parcial';
}
