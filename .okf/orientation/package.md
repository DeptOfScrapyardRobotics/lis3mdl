---
type: Module
title: Package (0.7)
description: dept-of-scrapyard-robotics/lis3mdl Composer identity, namespace, and discovery.
resource: composer.json
tags: [orientation, package, 0.7, lis3mdl]
generated: { by: cursor-agent/grok-4.5, at: "2026-08-11T20:00:00Z" }
verified: { by: null, at: null }
status: draft
sources:
  - id: composer
    resource: composer.json
    title: Package composer.json
  - id: provider
    resource: src/LIS3MDLServiceProvider.php
    title: LIS3MDLServiceProvider
  - id: gitattributes
    resource: .gitattributes
    title: Dist export-ignore
---

# Identity

| Field | Value |
|-------|-------|
| Composer | `dept-of-scrapyard-robotics/lis3mdl` **0.7.0** |
| PHP | `^8.4\|^8.5\|^8.6` |
| Namespace | `DeptOfScrapyardRobotics\Sensors\LIS3MDL\` → `src/` |
| Provider | `DeptOfScrapyardRobotics\Sensors\LIS3MDL\LIS3MDLServiceProvider` (package root, not `Providers/`) |
| Catalog slug | `lis3mdl` |

# Requires

| Package | Constraint |
|---------|------------|
| `fabricate/nuts-and-bolts` | `^0.7.0` |
| `gpio/circuits` | `^0.7.0` |
| `gpio/contracts` | `^0.7.0` |
| `gpio/digital` | `^0.7.0` |
| `gpio/i2c` | `^0.7.0` |
| `waveforms/contracts` | `^0.7.0` |

Waveforms supplies `Waveforms\Contracts\Motion\MeasuresMagneticFields` (and the `Magnetometer` wrapper).[^composer]

Suggested (optional): `microscrap/i2c`, `microscrap/mpsse` at `^0.7.0`.[^composer]

# Discovery

`extra.scrapyard-io.providers` lists `LIS3MDLServiceProvider`. That provider registers the catalog IC, wires `lis3mdl:make-profile` into `circuit:make-profile`, and registers the `lis3mdl-smoke` sketch.[^provider]

# Dist

`.okf/` and `AGENTS.md` are `export-ignore` — Composer dist tarballs omit them.[^gitattributes]

# Related

* [LIS3MDL IC](../core/lis3mdl.md)
* [Circuits integration](../core/circuits.md)

[^composer]: Package composer.json
[^provider]: LIS3MDLServiceProvider
[^gitattributes]: Dist export-ignore
