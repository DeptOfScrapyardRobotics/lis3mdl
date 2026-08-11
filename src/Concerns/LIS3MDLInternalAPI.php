<?php

namespace DeptOfScrapyardRobotics\Sensors\LIS3MDL\Concerns;

use DeptOfScrapyardRobotics\Sensors\LIS3MDL\Enums\LIS3MDLChipId;
use DeptOfScrapyardRobotics\Sensors\LIS3MDL\Enums\LIS3MDLDataRate;
use DeptOfScrapyardRobotics\Sensors\LIS3MDL\Enums\LIS3MDLOpCode;
use DeptOfScrapyardRobotics\Sensors\LIS3MDL\Enums\LIS3MDLOperationMode;
use DeptOfScrapyardRobotics\Sensors\LIS3MDL\Enums\LIS3MDLRange;
use DeptOfScrapyardRobotics\Sensors\LIS3MDL\LIS3MDLException;
use Fabricate\NutsAndBolts\Concerns\Splices16Bits;
use GeneralPurposeIO\Contracts\Circuits\BootScaffolding;

trait LIS3MDLInternalAPI
{
    use BootScaffolding;
    use Splices16Bits;

    /** Cached range for scale conversion without an extra I2C round-trip on every sample. */
    protected LIS3MDLRange $rangeBuffered = LIS3MDLRange::GAUSS_4;

    /**
     * @param  array<int, int>  $command_data
     */
    protected function sendCommand(LIS3MDLOpCode $register, array $command_data = []): int
    {
        return $this->transport->write($register->value, $command_data);
    }

    /**
     * @return array<int, int>
     */
    protected function readData(LIS3MDLOpCode $register, int $length): array
    {
        return $this->transport->read($register->value, $length);
    }

    /**
     * Soft-reset via CTRL_REG2 REBOOT bit, then refresh buffered range.
     */
    public function reset(): void
    {
        $ctrl2 = $this->readData(LIS3MDLOpCode::CTRL_REG2, 1)[0] ?? 0;
        $this->sendCommand(LIS3MDLOpCode::CTRL_REG2, [$ctrl2 | (1 << 2)]);
        usleep(10_000);
        $this->getRange();
    }

    /**
     * @throws LIS3MDLException
     */
    protected function _boot(): void
    {
        $this->confirmChipId();
        $this->reset();
        $this->setDataRate(LIS3MDLDataRate::HZ_155);
        $this->setRange(LIS3MDLRange::GAUSS_4);
        $this->setOperationMode(LIS3MDLOperationMode::CONTINUOUS);
    }

    /**
     * @throws LIS3MDLException
     */
    protected function confirmChipId(): void
    {
        $id = $this->getDeviceId();
        $expected = LIS3MDLChipId::EXPECTED->value;

        if ($id !== $expected) {
            throw LIS3MDLException::invalidChipId($id, $expected);
        }
    }

    /**
     * Convert raw LSB count to microtesla (µT).
     *
     * Adafruit path: gauss = raw / lsbPerGauss; µT = gauss * 100.
     */
    protected function rawToMicrotesla(int $raw): float
    {
        return ($raw / $this->rangeBuffered->lsbPerGauss()) * 100.0;
    }

    /**
     * Read-modify-write a bit field inside a control register.
     */
    protected function writeRegisterBits(LIS3MDLOpCode $register, int $mask, int $shift, int $value): void
    {
        $current = $this->readData($register, 1)[0] ?? 0;
        $cleared = $current & ~($mask << $shift);
        $updated = $cleared | (($value & $mask) << $shift);
        $this->sendCommand($register, [$updated]);
    }

    protected function readRegisterBits(LIS3MDLOpCode $register, int $mask, int $shift): int
    {
        $current = $this->readData($register, 1)[0] ?? 0;

        return ($current >> $shift) & $mask;
    }
}
