<?php

namespace DeptOfScrapyardRobotics\Sensors\LIS3MDL\Concerns;

use DeptOfScrapyardRobotics\Sensors\LIS3MDL\Enums\LIS3MDLDataRate;
use DeptOfScrapyardRobotics\Sensors\LIS3MDL\Enums\LIS3MDLOpCode;
use DeptOfScrapyardRobotics\Sensors\LIS3MDL\Enums\LIS3MDLOperationMode;
use DeptOfScrapyardRobotics\Sensors\LIS3MDL\Enums\LIS3MDLPerformanceMode;
use DeptOfScrapyardRobotics\Sensors\LIS3MDL\Enums\LIS3MDLRange;

trait LIS3MDLAPI
{
    use LIS3MDLInternalAPI;

    public function getDeviceId(): int
    {
        return $this->readData(LIS3MDLOpCode::WHO_AM_I, 1)[0] ?? 0xFF;
    }

    /**
     * @return array{0: int, 1: int, 2: int} signed raw X/Y/Z
     */
    public function getRawAxes(): array
    {
        $data = $this->readData(LIS3MDLOpCode::OUT_X_L, 6);

        return [
            $this->s16le($data[0] ?? 0, $data[1] ?? 0),
            $this->s16le($data[2] ?? 0, $data[3] ?? 0),
            $this->s16le($data[4] ?? 0, $data[5] ?? 0),
        ];
    }

    public function getRawX(): int
    {
        return $this->getRawAxes()[0];
    }

    public function getRawY(): int
    {
        return $this->getRawAxes()[1];
    }

    public function getRawZ(): int
    {
        return $this->getRawAxes()[2];
    }

    public function getRange(): LIS3MDLRange
    {
        $bits = $this->readRegisterBits(LIS3MDLOpCode::CTRL_REG2, 0b11, 5);
        $this->rangeBuffered = LIS3MDLRange::from($bits);

        return $this->rangeBuffered;
    }

    public function setRange(LIS3MDLRange $range): void
    {
        $this->writeRegisterBits(LIS3MDLOpCode::CTRL_REG2, 0b11, 5, $range->value);
        $this->rangeBuffered = $range;
    }

    public function getDataRate(): LIS3MDLDataRate
    {
        $bits = $this->readRegisterBits(LIS3MDLOpCode::CTRL_REG1, 0b1111, 1);

        return LIS3MDLDataRate::from($bits);
    }

    public function setDataRate(LIS3MDLDataRate $dataRate): void
    {
        match ($dataRate) {
            LIS3MDLDataRate::HZ_155 => $this->setPerformanceMode(LIS3MDLPerformanceMode::ULTRA_HIGH),
            LIS3MDLDataRate::HZ_300 => $this->setPerformanceMode(LIS3MDLPerformanceMode::HIGH),
            LIS3MDLDataRate::HZ_560 => $this->setPerformanceMode(LIS3MDLPerformanceMode::MEDIUM),
            LIS3MDLDataRate::HZ_1000 => $this->setPerformanceMode(LIS3MDLPerformanceMode::LOW_POWER),
            default => null,
        };

        usleep(10_000);
        $this->writeRegisterBits(LIS3MDLOpCode::CTRL_REG1, 0b1111, 1, $dataRate->value);
    }

    public function getPerformanceMode(): LIS3MDLPerformanceMode
    {
        $bits = $this->readRegisterBits(LIS3MDLOpCode::CTRL_REG1, 0b11, 5);

        return LIS3MDLPerformanceMode::from($bits);
    }

    public function setPerformanceMode(LIS3MDLPerformanceMode $mode): void
    {
        $this->writeRegisterBits(LIS3MDLOpCode::CTRL_REG1, 0b11, 5, $mode->value);
        $this->writeRegisterBits(LIS3MDLOpCode::CTRL_REG4, 0b11, 2, $mode->value);
    }

    public function getOperationMode(): LIS3MDLOperationMode
    {
        $bits = $this->readRegisterBits(LIS3MDLOpCode::CTRL_REG3, 0b11, 0);

        return LIS3MDLOperationMode::from($bits);
    }

    public function setOperationMode(LIS3MDLOperationMode $mode): void
    {
        $this->writeRegisterBits(LIS3MDLOpCode::CTRL_REG3, 0b11, 0, $mode->value);
    }

    /**
     * True when STATUS ZYXDA (new XYZ data available) is set.
     */
    public function magneticFieldAvailable(): bool
    {
        $status = $this->readData(LIS3MDLOpCode::STATUS, 1)[0] ?? 0;

        return ($status & 0x08) !== 0;
    }

    public function selfTest(bool $enabled): void
    {
        $this->writeRegisterBits(LIS3MDLOpCode::CTRL_REG1, 0b1, 0, $enabled ? 1 : 0);
    }
}
