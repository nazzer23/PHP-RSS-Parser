<?php

namespace Nazzer\PhpRssParser\Helpers;
class DateTimeHelper
{
    public static function isValidDateTime(string $dateTime): bool
    {
        return self::getDateTime($dateTime) !== null;
    }

    public static function getDateTime(string $dateTime): ?\DateTime
    {
        try {
            return new \DateTime($dateTime);
        } catch (\Exception $e) {
            return null;
        }
    }
}