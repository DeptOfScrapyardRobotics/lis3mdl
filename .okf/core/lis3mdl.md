---
type: Module
title: LIS3MDL IC
description: ST LIS3MDL SensorIC — attributes, I2C factory, boot, µT axis samples.
resource: src/LIS3MDL.php
tags: [core, ic, sensor, i2c, magnetometer]
generated: { by: cursor-agent/grok-4.5, at: "2026-08-11T20:00:00Z" }
verified: { by: null, at: null }
status: draft
sources:
  - id: ic
    resource: src/LIS3MDL.php
    title: LIS3MDL class
  - id: transport
    resource: src/LIS3MDLCarrierTransport.php
    title: LIS3MDLCarrierTransport
  - id: io
    resource: src/Concerns/LIS3MDLIO.php
    title: LIS3MDLIO trait
  - id: internal
    resource: src/Concerns/LIS3MDLInternalAPI.php
    title: LIS3MDLInternalAPI (BootScaffolding)
  - id: api
    resource: src/Concerns/LIS3MDLAPI.php
    title: LIS3MDLAPI
  - id: i2c-addr
    resource: src/Enums/LIS3MDLI2CAddress.php
    title: LIS3MDLI2CAddress enum
  - id: range
    resource: src/Enums/LIS3MDLRange.php
    title: LIS3MDLRange enum
  - id: chip-id
    resource: src/Enums/LIS3MDLChipId.php
    title: LIS3MDLChipId enum
---

# Role

ST LIS3MDL 3-axis magnetometer driver. Extends `GeneralPurposeIO\Circuits\Types\SensorIC`, implements `BootSequence` and `Waveforms\Contracts\Motion\MeasuresMagneticFields`. Axis samples return **microtesla (µT)**.[^ic]

# Attributes

```php
#[IntegratedCircuit('I2C')]
#[Pinout(['I2C' => ['driver', 'device', 'slave']])]
```

# Factories

| Factory | Primary args | Notes |
|---------|--------------|-------|
| `::i2c($device, $adapter, $slave, …)` | `device`, `adapter`, `slave` (default `LIS3MDLI2CAddress::SA1_LOW` = `0x1C`) | Builds via `I2C::adapter` → `fromI2CBus`; alt address `0x1E` (`SA1_HIGH`) |
| `fromI2CBus` | Already-open `I2CSlave` | Lower-level entry |

Default `boot_now` is `true` on factories; constructor default is `false`.[^ic][^i2c-addr]

# Transport and boot

- Wire path: `LIS3MDLCarrierTransport` + `LIS3MDLIO` (I2C only). Multi-byte reads set SUB(7) for auto-increment. Uses Nab `Splices16Bits`.[^transport][^io]
- Boot (`_boot`): confirm WHO_AM_I `0x3D`, soft-reset, data rate 155 Hz, range ±4 gauss, continuous conversion (Adafruit `_init` parity).[^internal][^chip-id]

# Units

Raw LSB → gauss via `LIS3MDLRange::lsbPerGauss()` → µT with `× 100` (1 gauss = 100 µT). Buffered range avoids a register read on every `x()`/`y()`/`z()`.[^range][^api]

# Local enums (package-owned)

| Enum | Role |
|------|------|
| `LIS3MDLI2CAddress` | `0x1C` / `0x1E` from SA1 |
| `LIS3MDLChipId` | Expected WHO_AM_I `0x3D` |
| `LIS3MDLOpCode` | Register map |
| `LIS3MDLRange` | ±4/8/12/16 gauss + LSB/gauss scale |
| `LIS3MDLDataRate` | 0.625–1000 Hz (incl. FAST_ODR) |
| `LIS3MDLPerformanceMode` | LP / MP / HP / UHP |
| `LIS3MDLOperationMode` | continuous / single / power-down |
| `LIS3MDLCatalogIc` | Catalog slug `lis3mdl` |

# Related

* [Circuits integration](circuits.md)
* [Package (0.7)](../orientation/package.md)
* [Fabricate leftovers](../traps/fabricate-leftovers.md)

[^ic]: LIS3MDL class
[^transport]: LIS3MDLCarrierTransport
[^io]: LIS3MDLIO trait
[^internal]: LIS3MDLInternalAPI (BootScaffolding)
[^api]: LIS3MDLAPI
[^i2c-addr]: LIS3MDLI2CAddress enum
[^range]: LIS3MDLRange enum
[^chip-id]: LIS3MDLChipId enum
