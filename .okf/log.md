# Directory Update Log

## 2026-08-11

* **Fix (draft)**: Composer `require` uses leaf components (`gpio/*`, `waveforms/contracts` or `tubes/contracts`, `fabricate/nuts-and-bolts`) — no `scrapyard-io/gpio-framework` / `scrapyard-io/waveforms` / `scrapyard-io/tubes` kitchen sinks. Amended [package](orientation/package.md).

* **Creation**: Initial `.okf` for `dept-of-scrapyard-robotics/lis3mdl` 0.7 — package orientation, LIS3MDL SensorIC (I2C factory, `MeasuresMagneticFields` µT samples, WHO_AM_I 0x3D, continuous conversion boot), Circuits registration/profiles/smoke, Fabricate leftovers trap, lean `AGENTS.md`, package `README.md`. Reference: Adafruit_LIS3MDL.
