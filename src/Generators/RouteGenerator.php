<?php

namespace InnoAya\Mojura\Generators;

use InnoAya\Mojura\Str;
use Exception;
use Illuminate\Support\Facades\File;

class RouteGenerator extends Generator
{
    /**
     * Generate a route.
     *
     *
     * @throws Exception
     */
    public function generate(string $route, string $versionOrDirectory = '', string $routeFileType = 'api', bool $force = false): string
    {
        // $route = Str::route($route);
        $versionOrDirectory = Str::directory($versionOrDirectory);

        $versionOrDirectory = $versionOrDirectory ? "/$versionOrDirectory" : '';

        $directoryPath = base_path("routes/$routeFileType$versionOrDirectory");
        $filename = "$route.php";
        $filePath = "$directoryPath/$filename";

        $this->throwIfFileExists($filePath, $force);

        $stubContents = $this->getStubContents();

        $stubContents = $this->replacePlaceholders($stubContents, [
            'route' => $route,
            'versionOrDirectory' => $versionOrDirectory,
        ]);

        $this->generateFile($directoryPath, $filePath, $stubContents);

        return $filePath;
    }

    /**
     * Get the appropriate stub contents.
     */
    private function getStubContents(): string
    {
        $stubFile = resource_path('stubs/vendor/mojura/route.php.stub');
        if (!File::exists($stubFile)) {
            $stubFile = __DIR__ . '/../../resources/stubs/route.php.stub';
        }

        return File::get($stubFile);
    }
}
