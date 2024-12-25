<?php

namespace InnoAya\Mojura\Commands;

use InnoAya\Mojura\Generators\FeatureGenerator;

class FeatureMakeCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    public $signature = 'mojura:feature
                        {feature : Feature}
                        {module : Module}
                        {directory? : Directory}
                        {--F|force : Overwrite existing files}';

    /**
     * The description the console command.
     *
     * @var string
     */
    public $description = 'Create a new feature in a module';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        try {
            $feature = $this->argument('feature');
            $module = $this->argument('module');
            $directory = $this->argument('directory');
            $force = $this->option('force');

            $output = (new FeatureGenerator())->generate($feature, $module, $directory, $force);

            $this->printFileGeneratedOutput($output);
        } catch (\Exception $exception) {
            $this->printFileGenerationErrorOutput($exception->getMessage());
        }

        return 0;
    }
}
