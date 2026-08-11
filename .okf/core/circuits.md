---
type: Module
title: Circuits integration
description: Catalog registration, lis3mdl:make-profile, profiles, and lis3mdl-smoke sketch.
resource: src/LIS3MDLServiceProvider.php
tags: [circuits, catalog, profile, smoke, workshop]
generated: { by: cursor-agent/grok-4.5, at: "2026-08-11T20:00:00Z" }
verified: { by: null, at: null }
status: draft
sources:
  - id: provider
    resource: src/LIS3MDLServiceProvider.php
    title: LIS3MDLServiceProvider
  - id: catalog
    resource: src/Enums/LIS3MDLCatalogIc.php
    title: LIS3MDLCatalogIc
  - id: console-enum
    resource: src/Enums/LIS3MDLConsoleCommand.php
    title: LIS3MDLConsoleCommand
  - id: make-profile
    resource: src/Console/LIS3MDLMakeProfileCommand.php
    title: lis3mdl:make-profile
  - id: smoke
    resource: src/Sketches/LIS3MDLSmoke.php
    title: lis3mdl-smoke
---

# Role

This package **owns the LIS3MDL chip driver** and registers it with gpio-framework Circuits. Registry / fluent / profile **semantics** live in `scrapyard-io/gpio-framework` — open that package’s `.okf` for `CircuitRegistry`, `PendingCircuit`, and `circuit:make-profile` behavior.

# Catalog

On `boot()`:[^provider]

```php
Circuit::addCircuit(LIS3MDLCatalogIc::LIS3MDL->value, LIS3MDL::class); // 'lis3mdl'

$maker = LIS3MDLConsoleCommand::MAKE_PROFILE->value; // 'lis3mdl:make-profile'
foreach (LIS3MDLCatalogIc::cases() as $ic) {
    Circuit::registerProfileCommand($ic->value, $maker);
}
```

Slug enum: `LIS3MDLCatalogIc::LIS3MDL` → `lis3mdl`.[^catalog][^console-enum]

# Profiles

Publish gpio Circuits config first (from gpio-framework), then scaffold:

```bash
workshop vendor:publish --tag=gpio-circuits-config
workshop circuit:make-profile          # picks any installed IC; LIS3MDL delegates here
workshop lis3mdl:make-profile          # LIS3MDL only
```

`lis3mdl:make-profile` uses `ScaffoldsCircuitProfiles` + `CircuitAttributeInspector` — prompts from `#[IntegratedCircuit]` / `#[Pinout]`, writes `config/circuits.php` with `boot_now => true`.[^make-profile]

```php
Circuit::profile('mag_board'); // recipe ic => lis3mdl
```

# Smoke sketch

Sketch slug: `lis3mdl-smoke` (`#[SketchAttribute('lis3mdl-smoke')]`), registered when `SketchRegistry` is bound.[^provider][^smoke]

```bash
php workshop runner lis3mdl-smoke
php workshop runner lis3mdl-smoke --profile=mag_board
```

Requires at least one profile whose `ic` is `lis3mdl`. Provisions **only** via `Circuit::profile()` — prints `X/Y/Z` µT (~250 ms sample cadence) until Ctrl-C; closes the sensor on shutdown.[^smoke]

# Related

* [LIS3MDL IC](lis3mdl.md)
* [Package (0.7)](../orientation/package.md)

[^provider]: LIS3MDLServiceProvider
[^catalog]: LIS3MDLCatalogIc
[^console-enum]: LIS3MDLConsoleCommand
[^make-profile]: lis3mdl:make-profile
[^smoke]: lis3mdl-smoke
