<?php

namespace DeptOfScrapyardRobotics\Sensors\LIS3MDL\Concerns;

use DeptOfScrapyardRobotics\Sensors\LIS3MDL\LIS3MDLException;
use Fabricate\NutsAndBolts\Concerns\Splices16Bits;

trait LIS3MDLIO
{
    use Splices16Bits;

    /**
     * Register read. Multi-byte transfers set SUB(7) for auto-increment (ST datasheet).
     *
     * @return array<int, int>
     *
     * @throws LIS3MDLException
     */
    protected function i2cRead(int $register, int $length): array
    {
        if (! is_null($this->i2c)) {
            $addr = $register & 0x7F;
            if ($length > 1) {
                $addr |= 0x80;
            }

            return $this->i2c->writeRead([$this->getLowByte($addr)], $length);
        }

        throw LIS3MDLException::transportMissingProtocol();
    }

    /**
     * @param  array<int, int>  $data
     *
     * @throws LIS3MDLException
     */
    protected function i2cWrite(int $register, array $data = []): int
    {
        if (! is_null($this->i2c)) {
            $payload = [$this->getLowByte($register & 0x7F), ...$data];

            return $this->i2c->write($payload);
        }

        throw LIS3MDLException::transportMissingProtocol();
    }
}
