<?php

namespace DeptOfScrapyardRobotics\Sensors\LIS3MDL\Enums;

/**
 * LIS3MDL register map (subset used by this driver).
 *
 * @see https://github.com/adafruit/Adafruit_LIS3MDL
 */
enum LIS3MDLOpCode: int
{
    case WHO_AM_I = 0x0F;
    case CTRL_REG1 = 0x20;
    case CTRL_REG2 = 0x21;
    case CTRL_REG3 = 0x22;
    case CTRL_REG4 = 0x23;
    case STATUS = 0x27;
    case OUT_X_L = 0x28;
    case INT_CFG = 0x30;
    case INT_THS_L = 0x32;
}
