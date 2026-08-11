---
type: Trap
title: Fabricate leftovers
description: LIS3MDL 0.7 uses GeneralPurposeIO Circuits and Waveforms motion contracts — not Fabricate Circuits leftovers.
tags: [traps, fabricate, circuits, sensors, waveforms]
generated: { by: cursor-agent/grok-4.5, at: "2026-08-11T20:00:00Z" }
verified: { by: null, at: null }
status: draft
sources:
  - id: ic
    resource: src/LIS3MDL.php
    title: LIS3MDL imports
  - id: internal-api
    resource: src/Concerns/LIS3MDLInternalAPI.php
    title: BootScaffolding + Nab Splices16Bits
  - id: provider
    resource: src/LIS3MDLServiceProvider.php
    title: Circuit MagicAlias import
---

# Trap

Do **not** import or revive:

- `Fabricate\Contracts\Circuits\*`
- `Fabricate\Circuits\*` (including any old Fabricate boot / DataRegister paths)
- Fabricate-era sensor contract types for magnetometers

# Use instead

| Concern | Correct FQCN |
|---------|----------------|
| Taxonomy base | `GeneralPurposeIO\Circuits\Types\SensorIC` |
| Attributes / BootSequence / BootScaffolding | `GeneralPurposeIO\Contracts\Circuits\Attributes\*`, `BootSequence`, `BootScaffolding` |
| Circuit alias | `GeneralPurposeIO\Core\MagicAliases\Circuit` |
| Motion capability | `Waveforms\Contracts\Motion\MeasuresMagneticFields` |
| Bit helpers | `Fabricate\NutsAndBolts\Concerns\Splices16Bits` (Nab — OK) |

`LIS3MDL` already wires GeneralPurposeIO Circuits types + Waveforms `MeasuresMagneticFields`; BootScaffolding + Nab `Splices16Bits` are intentional.[^ic][^internal-api][^provider]

# Related

* [LIS3MDL IC](../core/lis3mdl.md)
* [Circuits integration](../core/circuits.md)

[^ic]: LIS3MDL imports
[^internal-api]: BootScaffolding + Nab Splices16Bits
[^provider]: Circuit MagicAlias import
