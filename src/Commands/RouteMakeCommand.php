<?php

namespace InnoAya\Mojura\Commands;

use InnoAya\Mojura\Generators\RouteGenerator;

class RouteMakeCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    public $signature = 'mojura:route
                        {route : Route file name}
                        {versionOrDirectory? : API version or Directory}
                        {--WEB|web : Generate Web route file}
                        {--F|force : Overwrite existing files}';

    /**
     * The description the console command.
     *
     * @var string
     */
    public $description = 'Create a new route file';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        try {
            $route = $this->argument('route');
            $versionOrDirectory = $this->argument('versionOrDirectory') ?? '';

            // default to api route file type
            $routeFileType = $this->option('web') ? 'web' : 'api';
            $force = $this->option('force');

            $output = (new RouteGenerator())->generate($route, $versionOrDirectory, $routeFileType, $force);

            $this->printFileGeneratedOutput($output);
        } catch (\Exception $exception) {
            $this->printFileGenerationErrorOutput($exception->getMessage());
        }

        if (! config('mojura.enable_routes')) {
            $this->printDisableRoutesWarning();
        }

        return 0;
    }
}
