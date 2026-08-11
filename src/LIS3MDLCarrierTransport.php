<?php

namespace DeptOfScrapyardRobotics\Sensors\LIS3MDL;

use DeptOfScrapyardRobotics\Sensors\LIS3MDL\Concerns\LIS3MDLIO;
use GeneralPurposeIO\I2C\I2CSlave;

class LIS3MDLCarrierTransport
{
    use LIS3MDLIO;

    public readonly string $active_transport;

    /**
     * @throws LIS3MDLException
     */
    public function __construct(
        protected ?I2CSlave $i2c = null,
    ) {
        $this->active_transport = $this->detectTransport();
    }

    /**
     * @param  array<int, int>  $data
     *
     * @throws LIS3MDLException
     */
    public function write(int $register, array $data): int
    {
        $method = "{$this->active_transport}Write";

        return $this->{$method}($register, $data);
    }

    /**
     * @return array<int, int>
     *
     * @throws LIS3MDLException
     */
    public function read(int $register, int $length): array
    {
        $method = "{$this->active_transport}Read";

        return $this->{$method}($register, $length);
    }

    /**
     * @throws LIS3MDLException
     */
    protected function detectTransport(): string
    {
        if (! is_null($this->i2c)) {
            return 'i2c';
        }

        throw LIS3MDLException::transportMissingProtocol();
    }

    public function close(): void
    {
        $this->i2c?->close();
    }
}
