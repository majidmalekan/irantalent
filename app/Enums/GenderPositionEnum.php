<?php

namespace App\Enums;

use JetBrains\PhpStorm\ArrayShape;
use Spatie\Enum\Laravel\Enum;
/**
 * @method static self Male()
 * @method static self Female()
 */
final class GenderPositionEnum extends Enum
{
    #[ArrayShape(['Male' => "string", 'Female' => "string"])]
    protected static function values(): array
    {
        return [
          'Male'=>lcfirst('Male'),
          'Female'=>lcfirst('Female'),
        ];
    }
    #[ArrayShape(['Male' => "string", 'Female' => "string"])]
    protected static function labels(): array
    {
        return [
          'Male'=>'مرد',
          'Female'=>'زن',
        ];
    }
}
