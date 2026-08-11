<?php

namespace DeptOfScrapyardRobotics\Sensors\LIS3MDL\Console;

use DeptOfScrapyardRobotics\Sensors\LIS3MDL\Enums\LIS3MDLCatalogIc;
use Fabricate\Console\Command;
use GeneralPurposeIO\Circuits\CircuitRegistry;
use GeneralPurposeIO\Circuits\Console\Concerns\ScaffoldsCircuitProfiles;
use GeneralPurposeIO\Circuits\Support\CircuitAttributeInspector;
use GeneralPurposeIO\Contracts\Circuits\CircuitException;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'lis3mdl:make-profile')]
class LIS3MDLMakeProfileCommand extends Command
{
    use ScaffoldsCircuitProfiles;

    protected ?string $signature = 'lis3mdl:make-profile
                    {ic? : Catalog slug (lis3mdl)}
                    {name? : Profile key to write into config/circuits.php}
                    {--protocol= : Protocol option label or factory name when non-interactive}';

    protected string $description = 'Scaffold a circuits.php profile for an LIS3MDL magnetometer';

    public function handle(CircuitRegistry $registry): int
    {
        $available = array_values(array_filter(
            LIS3MDLCatalogIc::slugs(),
            static fn (string $ic): bool => isset($registry->listCircuits()[$ic]),
        ));

        if ($available === []) {
            $this->components->error('No LIS3MDL ICs are registered.');

            return self::FAILURE;
        }

        $ic = $this->argument('ic');
        if (is_null($ic) || $ic === '') {
            $ic = $this->choice('Which LIS3MDL IC?', $available);
        }

        $ic = (string) $ic;

        if (is_null(LIS3MDLCatalogIc::tryFrom($ic))) {
            $this->components->error("IC [{$ic}] is not an LIS3MDL sensor.");

            return self::FAILURE;
        }

        try {
            $options = CircuitAttributeInspector::protocolOptions($registry->resolveClass($ic));
        } catch (CircuitException $e) {
            $this->components->error($e->getMessage());

            return self::FAILURE;
        }

        $selected = $this->resolveProtocolOption($options);
        if (is_null($selected)) {
            return self::FAILURE;
        }

        $name = $this->argument('name');
        if (is_null($name) || $name === '') {
            $name = $this->ask('Profile name', $ic);
        }

        return $this->writePromptedProfile($ic, (string) $name, $selected);
    }
}
