<?php

namespace DeptOfScrapyardRobotics\Sensors\LIS3MDL\Enums;

/**
 * Operating mode — CTRL_REG3 bits [1:0].
 */
enum LIS3MDLOperationMode: int
{
    case CONTINUOUS = 0b00;
    case SINGLE = 0b01;
    case POWER_DOWN = 0b11;
}
