<?php

namespace DeptOfScrapyardRobotics\Sensors\LIS3MDL\Enums;

/**
 * I2C 7-bit address — SA1 pin selects between the two options.
 */
enum LIS3MDLI2CAddress: int
{
    /** SA1 low / grounded — Adafruit default breakout address */
    case SA1_LOW = 0x1C;

    /** SA1 high / energized */
    case SA1_HIGH = 0x1E;
}
