<?php

namespace DeptOfScrapyardRobotics\Sensors\LIS3MDL\Enums;

/**
 * Output data rate — CTRL_REG1 bits [4:1] (includes FAST_ODR as bit 0 of the nibble).
 *
 * Fast ODR rates (155–1000 Hz) also force a matching performance mode on write.
 */
enum LIS3MDLDataRate: int
{
    case HZ_0_625 = 0b0000;
    case HZ_1_25 = 0b0010;
    case HZ_2_5 = 0b0100;
    case HZ_5 = 0b0110;
    case HZ_10 = 0b1000;
    case HZ_20 = 0b1010;
    case HZ_40 = 0b1100;
    case HZ_80 = 0b1110;
    case HZ_155 = 0b0001;
    case HZ_300 = 0b0011;
    case HZ_560 = 0b0101;
    case HZ_1000 = 0b0111;

    public function hertz(): float
    {
        return match ($this) {
            self::HZ_0_625 => 0.625,
            self::HZ_1_25 => 1.25,
            self::HZ_2_5 => 2.5,
            self::HZ_5 => 5.0,
            self::HZ_10 => 10.0,
            self::HZ_20 => 20.0,
            self::HZ_40 => 40.0,
            self::HZ_80 => 80.0,
            self::HZ_155 => 155.0,
            self::HZ_300 => 300.0,
            self::HZ_560 => 560.0,
            self::HZ_1000 => 1000.0,
        };
    }
}
