<?php

namespace DeptOfScrapyardRobotics\Sensors\LIS3MDL\Enums;

/**
 * XY (CTRL_REG1 bits [6:5]) and Z (CTRL_REG4 bits [3:2]) performance mode.
 */
enum LIS3MDLPerformanceMode: int
{
    case LOW_POWER = 0b00;
    case MEDIUM = 0b01;
    case HIGH = 0b10;
    case ULTRA_HIGH = 0b11;
}
