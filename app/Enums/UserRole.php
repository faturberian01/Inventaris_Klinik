<?php

namespace App\Enums;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Names;

enum UserRole: string
{
    use InvokableCases, Names;

    case ADMIN = 'admin';
    case EMPLOYEE = 'employee';

    public static function getList(): array
    {
        return [
            self::ADMIN() => 'Admin',
            self::EMPLOYEE() => 'Karyawan',
        ];
    }

    public function getColor()
    {
        return match ($this) {
            self::ADMIN => 'primary',
            self::EMPLOYEE => 'info',
        };
    }

    public function getTranslated(): string
    {
        return match ($this) {
            self::ADMIN => 'Admin',
            self::EMPLOYEE => 'Karyawan',
        };
    }
}
