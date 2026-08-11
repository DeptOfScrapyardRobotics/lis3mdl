<?php

namespace DeptOfScrapyardRobotics\Sensors\LIS3MDL\Enums;

/**
 * Full-scale magnetic range — CTRL_REG2 bits [6:5].
 *
 * Scale is LSB per gauss (Adafruit / ST sensitivity tables).
 * Convert to µT with: raw / lsbPerGauss() * 100 (1 gauss = 100 µT).
 */
enum LIS3MDLRange: int
{
    case GAUSS_4 = 0b00;
    case GAUSS_8 = 0b01;
    case GAUSS_12 = 0b10;
    case GAUSS_16 = 0b11;

    /** LSB per gauss for the selected range. */
    public function lsbPerGauss(): float
    {
        return match ($this) {
            self::GAUSS_4 => 6842.0,
            self::GAUSS_8 => 3421.0,
            self::GAUSS_12 => 2281.0,
            self::GAUSS_16 => 1711.0,
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::GAUSS_4 => '±4 gauss',
            self::GAUSS_8 => '±8 gauss',
            self::GAUSS_12 => '±12 gauss',
            self::GAUSS_16 => '±16 gauss',
        };
    }
}
