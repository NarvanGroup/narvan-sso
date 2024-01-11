<?php

namespace App\Traits\Api\V1;

trait EnumsTrait
{
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
