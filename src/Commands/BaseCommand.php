<?php

namespace InnoAya\Mojura\Commands;

use InnoAya\Mojura\Decorator;
use Illuminate\Console\Command;

class BaseCommand extends Command
{
    /**
     * Print pretty output once file has been generated.
     */
    public function printFileGeneratedOutput(string $output): void
    {
        $this->info(Decorator::getFileGeneratedOutput($output));
    }

    /**
     * Print pretty output once file has occurred error.
     */
    public function printFileGenerationErrorOutput(string $output): void
    {
        $this->error(Decorator::getFileGenerationErrorOutput($output));
    }

    /**
     * Print pretty output once file has occurred error.
     */
    public function printDisableRoutesWarning(): void
    {
        $this->error(Decorator::getDisableRoutesWarning());
    }
}
