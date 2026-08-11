# Agent guidelines — dept-of-scrapyard-robotics/lis3mdl

## Knowledge Bundle (OKF)

This package ships an Open Knowledge Format bundle at [`.okf/`](.okf/) (excluded from Composer dist via `.gitattributes` `export-ignore`).

Before changing this package or advising on LIS3MDL architecture:

1. Read [`.okf/index.md`](.okf/index.md) first (progressive disclosure).
2. Open only the linked concepts needed for the task.
3. Prefer `status: stable` concepts; treat `deprecated` as historical only. New/changed concepts stay `status: draft` until a human verifies them.
4. When you learn something durable about **this package**, update the affected `.okf` concept(s) and append `.okf/log.md`.
5. Keep the `.okf` bundle at the **package root** only — do not nest extra `.okf` folders under `src/`.
6. Circuits registry semantics belong in `scrapyard-io/gpio-framework`’s `.okf`. Motion contracts belong in `scrapyard-io/waveforms`.

## Package rules (quick) — 0.7.x

- Composer: `dept-of-scrapyard-robotics/lis3mdl` **0.7.0**. Namespace `DeptOfScrapyardRobotics\Sensors\LIS3MDL\`.
- Provider: `LIS3MDLServiceProvider` at package root. Catalog slug `lis3mdl`. Command `lis3mdl:make-profile`. Sketch `lis3mdl-smoke`.
- IC extends `GeneralPurposeIO\Circuits\Types\SensorIC`, implements `BootSequence` + `Waveforms\Contracts\Motion\MeasuresMagneticFields`.
- Factory: `i2c(...)` only (I2C). Axis samples return **microtesla (µT)** — 1 gauss = 100 µT.
- Nab `Splices16Bits` is OK. No Fabricate Circuits leftovers.
- Requires leaf components (not kitchen-sink frameworks): `fabricate/nuts-and-bolts`, `gpio/circuits`, `gpio/contracts`, `gpio/digital`, `gpio/i2c`, `waveforms/contracts`.
