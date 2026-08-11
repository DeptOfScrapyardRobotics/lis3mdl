<?php

namespace DeptOfScrapyardRobotics\Sensors\LIS3MDL;

use DeptOfScrapyardRobotics\Sensors\LIS3MDL\Concerns\LIS3MDLAPI;
use DeptOfScrapyardRobotics\Sensors\LIS3MDL\Enums\LIS3MDLI2CAddress;
use Exception;
use GeneralPurposeIO\Circuits\Types\SensorIC;
use GeneralPurposeIO\Contracts\Circuits\Attributes\IntegratedCircuit;
use GeneralPurposeIO\Contracts\Circuits\Attributes\Pinout;
use GeneralPurposeIO\Contracts\Circuits\BootSequence;
use GeneralPurposeIO\I2C\I2C;
use GeneralPurposeIO\I2C\I2CSlave;
use Waveforms\Contracts\Motion\MeasuresMagneticFields;

/**
 * ST LIS3MDL 3-axis magnetometer.
 *
 * @property-read int $device_id
 * @property-read float $x
 * @property-read float $y
 * @property-read float $z
 */
#[IntegratedCircuit('I2C')]
#[Pinout(['I2C' => ['driver', 'device', 'slave']])]
class LIS3MDL extends SensorIC implements BootSequence, MeasuresMagneticFields
{
    use LIS3MDLAPI;

    /**
     * @throws Exception
     */
    public function __construct(
        protected readonly LIS3MDLCarrierTransport $transport,
        bool $boot_now = false,
    ) {
        if ($boot_now) {
            $this->boot();
        }
    }

    /**
     * @throws LIS3MDLException
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'device_id' => $this->getDeviceId(),
            'x' => $this->x(),
            'y' => $this->y(),
            'z' => $this->z(),
            default => throw LIS3MDLException::invalidProperty($name, static::class),
        };
    }

    /**
     * Fresh X-axis sample in microtesla (µT).
     */
    public function x(): float
    {
        return $this->rawToMicrotesla($this->getRawX());
    }

    /**
     * Fresh Y-axis sample in microtesla (µT).
     */
    public function y(): float
    {
        return $this->rawToMicrotesla($this->getRawY());
    }

    /**
     * Fresh Z-axis sample in microtesla (µT).
     */
    public function z(): float
    {
        return $this->rawToMicrotesla($this->getRawZ());
    }

    public function close(): void
    {
        $this->transport->close();
    }

    /**
     * Creates an LIS3MDL instance with a standalone I2C connection.
     *
     * @throws LIS3MDLException
     */
    public static function i2c(
        string|int $device,
        ?string $adapter = null,
        int $slave = LIS3MDLI2CAddress::SA1_LOW->value,
        bool $boot_now = true,
    ): static {
        $i2c = I2C::adapter($adapter)
            ->device($device)
            ->bus()
            ->slave($slave);

        return static::fromI2CBus($i2c, $boot_now);
    }

    /**
     * Creates an LIS3MDL instance from a bootstrapped I2CSlave.
     *
     * @throws LIS3MDLException
     * @throws Exception
     */
    public static function fromI2CBus(
        I2CSlave $i2c,
        bool $boot_now = true,
    ): static {
        $transport = new LIS3MDLCarrierTransport(i2c: $i2c);

        return new static($transport, $boot_now);
    }
}
