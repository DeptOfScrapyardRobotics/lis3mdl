<?php

namespace DeptOfScrapyardRobotics\Sensors\LIS3MDL\Enums;

enum LIS3MDLCatalogIc: string
{
    case LIS3MDL = 'lis3mdl';

    /**
     * @return list<string>
     */
    public static function slugs(): array
    {
        return array_map(
            static fn (self $case): string => $case->value,
            self::cases(),
        );
    }
}
