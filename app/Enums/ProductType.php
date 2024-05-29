<?php

namespace App\Enums;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Names;
use ArchTech\Enums\Values;

enum ProductType: string
{
    use InvokableCases, Names, Values;

    case MEDICINE = 'medicine';
    case TOOL = 'tool';

    public static function getList(): array
    {
        return [
            self::MEDICINE() => 'Obat',
            self::TOOL() => 'Alat',
        ];
    }

    public function getColor()
    {
        return match ($this) {
            self::MEDICINE => 'primary',
            self::TOOL => 'info',
        };
    }

    public function getTranslated(): string
    {
        return match ($this) {
            self::MEDICINE => 'Obat',
            self::TOOL => 'Alat',
        };
    }
}
