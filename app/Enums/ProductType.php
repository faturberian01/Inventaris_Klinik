<?php

namespace App\Enums;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Names;
use ArchTech\Enums\Values;

enum ProductType: string
{
    use InvokableCases, Names, Values;


    case ALL = 'all';
    case MEDICINE = 'medicine';
    case TOOL = 'tool';

    public static function getList(): array
    {
        return [
            self::ALL() => 'All',
            self::MEDICINE() => 'Obat',
            self::TOOL() => 'Alat',
        ];
    }

    public function getColor()
    {
        return match ($this) {
            self::ALL => 'primary',
            self::MEDICINE => 'info',
            self::TOOL => 'success',
        };
    }

    public function getTranslated(): string
    {
        return match ($this) {
            self::ALL => '(Obat & Alat)',
            self::MEDICINE => 'Obat',
            self::TOOL => 'Alat',
        };
    }
}
