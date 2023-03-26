<?php

namespace App\Constants;

class Status
{
    const INACTIVE = -10;

    const PENDING = 1;
    const ACTIVE = 10;

    public static function getLabel(?int $status): string
    {
        return match ($status) {
            self::INACTIVE => __("Inactive"),
            self::PENDING => __("Pending"),
            self::ACTIVE => __("Active"),
            default => __("Not defined"),
        };
    }

    public static function getSelection(): array
    {
        return [
            self::INACTIVE => self::getLabel(self::INACTIVE),
            self::PENDING => self::getLabel(self::PENDING),
            self::ACTIVE => self::getLabel(self::ACTIVE),
        ];
    }
}
