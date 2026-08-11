<?php

namespace DeptOfScrapyardRobotics\Sensors\LIS3MDL;

use DeptOfScrapyardRobotics\Sensors\LIS3MDL\Console\LIS3MDLMakeProfileCommand;
use DeptOfScrapyardRobotics\Sensors\LIS3MDL\Enums\LIS3MDLCatalogIc;
use DeptOfScrapyardRobotics\Sensors\LIS3MDL\Enums\LIS3MDLConsoleCommand;
use DeptOfScrapyardRobotics\Sensors\LIS3MDL\Sketches\LIS3MDLSmoke;
use Fabricate\Contracts\Sketches\SketchRegistry;
use Fabricate\NutsAndBolts\ServiceProvider;
use GeneralPurposeIO\Core\MagicAliases\Circuit;

class LIS3MDLServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->container->singleton(LIS3MDLMakeProfileCommand::class);
        $this->commands([
            LIS3MDLMakeProfileCommand::class,
        ]);
    }

    public function boot(): void
    {
        Circuit::addCircuit(LIS3MDLCatalogIc::LIS3MDL->value, LIS3MDL::class);

        $maker = LIS3MDLConsoleCommand::MAKE_PROFILE->value;
        foreach (LIS3MDLCatalogIc::cases() as $ic) {
            Circuit::registerProfileCommand($ic->value, $maker);
        }

        $this->registerSketch();
    }

    protected function registerSketch(): void
    {
        if (! $this->container->bound(SketchRegistry::class)) {
            return;
        }

        /** @var SketchRegistry $registry */
        $registry = $this->container->make(SketchRegistry::class);

        if (! $registry->has('lis3mdl-smoke')) {
            $registry->registerConvention('lis3mdl-smoke', LIS3MDLSmoke::class);
        }
    }
}
