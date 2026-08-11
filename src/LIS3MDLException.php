<?php

namespace DeptOfScrapyardRobotics\Sensors\LIS3MDL;

use GeneralPurposeIO\Contracts\Circuits\CircuitException;

class LIS3MDLException extends CircuitException
{
    public static function transportMissingProtocol(): static
    {
        return new static('LIS3MDL devices require an I2C capable connection.');
    }

    public static function invalidChipId(int $chip_id, int $expected_id): static
    {
        return new static(sprintf(
            'Invalid LIS3MDL Device Chip ID — expected 0x%02X, got 0x%02X',
            $expected_id,
            $chip_id,
        ));
    }
}
