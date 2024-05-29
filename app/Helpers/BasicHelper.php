<?php

namespace App\Helpers;

class BasicHelper
{
    public static function getRupiahFormat(int|float $value, int $decimals = 0): string
    {
        return 'Rp. '.number_format($value, $decimals, ',', '.');
    }

    public static function dateForFileName(
        bool $withTimestamp = false,
        bool $withUnixId = false,
        bool $onlyTimestamp = false
    ): string {
        return implode('_', array_merge(
            [
                $onlyTimestamp ? time() : now()->format('d_m_y_H:i:s'),
            ],
            ($withTimestamp ? [time()] : []),
            ($withUnixId ? [uniqid()] : [])
        ));
    }
}
