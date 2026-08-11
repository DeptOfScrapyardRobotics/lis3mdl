---
okf_version: "0.2"
---

# dept-of-scrapyard-robotics/lis3mdl Knowledge Bundle

Package knowledge for `dept-of-scrapyard-robotics/lis3mdl` (ST LIS3MDL magnetometer driver, v0.7.x).
Read this index first; open only the concepts needed for the task.

**Trust rule:** Prefer `status: stable`. Treat `deprecated` as historical only. New agent-written concepts stay `status: draft` until a human verifies them.
**Placement:** Package-root `.okf/` only — never under `src/`.
**Links:** Concept cross-links use paths relative to each file.
**Scope:** This package’s IC surface, Circuits catalog registration, profiles, and smoke sketch. Registry semantics live in `scrapyard-io/gpio-framework`. Motion contracts (`MeasuresMagneticFields`) live in `scrapyard-io/waveforms`.
**Dist note:** `.okf/` and root `AGENTS.md` are `export-ignore` in `.gitattributes`.

# Orientation

* [Package (0.7)](orientation/package.md) - Composer identity, namespace, provider, dependencies.

# Core

* [LIS3MDL IC](core/lis3mdl.md) - SensorIC class, attributes, I2C factory, µT conversion, local enums.
* [Circuits integration](core/circuits.md) - Catalog slug, make-profile, profiles, smoke sketch.

# Traps

* [Fabricate leftovers](traps/fabricate-leftovers.md) - Use GeneralPurposeIO Circuits + Waveforms motion contracts; Nab `Splices16Bits` is OK.

# Log

* [Directory update log](log.md)
