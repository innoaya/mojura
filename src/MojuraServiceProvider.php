<?php
namespace InnoAya\Mojura;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class MojuraServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register bindings
    }

    public function boot()
    {
        // Publish configuration
        $this->publishes([
            __DIR__.'/../config/mojura.php' => config_path('mojura.php'),
        ], 'mojura-config');

        // Publish stubs
        $this->publishes([
            __DIR__.'/../resources/stubs' => resource_path('stubs/vendor/mojura'),
        ], 'mojura-stubs');

        // Register commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                \InnoAya\Mojura\Commands\RouteMakeCommand::class,
                \InnoAya\Mojura\Commands\ControllerMakeCommand::class,
                \InnoAya\Mojura\Commands\RequestMakeCommand::class,
                \InnoAya\Mojura\Commands\FeatureMakeCommand::class,
                \InnoAya\Mojura\Commands\JobMakeCommand::class,
            ]);
        }

        // Register routes if enabled
        if (config('mojura.enable_routes') && !App::routesAreCached()) {
            $this->registerRoutes();
        }
    }

    protected function registerRoutes()
    {
        $webRoutes = $this->getAllFilesOfADirectory(base_path('routes/web'), 'php');
        $apiRoutes = $this->getAllFilesOfADirectory(base_path('routes/api'), 'php');

        $webRoutesPrefix = config('mojura.web_routes_prefix');
        $apiRoutesPrefix = config('mojura.api_routes_prefix');

        foreach ($webRoutes as $route) {
            Route::middleware('web')
                ->prefix($webRoutesPrefix)
                ->group($route);
        }

        foreach ($apiRoutes as $route) {
            Route::middleware('api')
                ->prefix($apiRoutesPrefix)
                ->group($route);
        }
    }

    protected function getAllFilesOfADirectory($directory, $extension)
    {
        $files = [];

        if (! is_dir($directory)) {
            return $files;
        }

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($directory)
        );

        foreach ($iterator as $fileInfo) {
            if ($fileInfo->isFile() && (! $extension || $fileInfo->getExtension() === $extension)) {
                $files[] = $fileInfo->getPathname();
            }
        }

        return $files;
    }
}