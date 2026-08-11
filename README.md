# dept-of-scrapyard-robotics/lis3mdl (0.7)

I2C driver for the ST LIS3MDL 3-axis magnetometer. Extends `GeneralPurposeIO\Circuits\Types\SensorIC` and implements `Waveforms\Contracts\Motion\MeasuresMagneticFields` (axis samples in **µT**).

## Register

Provider registers catalog slug `lis3mdl` and wires `lis3mdl:make-profile` into `circuit:make-profile`.

## Profiles

```bash
workshop vendor:publish --tag=gpio-circuits-config
workshop circuit:make-profile          # picks any installed IC; LIS3MDL delegates here
workshop lis3mdl:make-profile          # LIS3MDL only
```

The command asks I2C adapter/device/slave from `#[Pinout]`, and always sets `boot_now => true`.

Default I2C slave is `0x1C` (`LIS3MDLI2CAddress::SA1_LOW`); use `0x1E` when SA1 is high.

```php
Circuit::profile('mag_board');
```

## Smoke sketch

Requires at least one LIS3MDL profile in `config/circuits.php`:

```bash
php workshop runner lis3mdl-smoke
php workshop runner lis3mdl-smoke --profile=mag_board
```

Provisions only via `Circuit::profile()` — prints X/Y/Z µT until you Ctrl-C.

## Waveforms wrapper

```php
use Waveforms\Motion\Magnetometer;

$mag = Magnetometer::circuit('mag_board');
echo $mag->x(); // µT
```
