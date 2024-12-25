<?php

namespace InnoAya\Mojura\Generators;

use InnoAya\Mojura\Str;
use Exception;
use Illuminate\Support\Facades\File;

class ControllerGenerator extends Generator
{
    /**
     * Generate a controller.
     *
     *
     * @throws Exception
     */
    public function generate(string $controller, string $module, string $directory = null, bool $force = false): string
    {
        $controller = Str::controller($controller);
        $module = Str::module($module);

        $path = $directory !== null ? "Modules/{$module}/Http/Controllers/{$directory}" : "Modules/{$module}/Http/Controllers";

        $directoryPath = app_path($path);
        $filename = "$controller.php";
        $filePath = "$directoryPath/$filename";

        $this->throwIfFileExists($filePath, $force);

        $stubContents = $this->getStubContents();

        $stubContents = $this->replacePlaceholders($stubContents, [
            'namespace' => $directory !== null ? "App\\Modules\\{$module}\\Http\\Controllers\\{$directory}" : "App\\Modules\\{$module}\\Http\\Controllers",
            'controller' => $controller,
        ]);

        $this->generateFile($directoryPath, $filePath, $stubContents);

        return $filePath;
    }

    /**
     * Get the appropriate stub contents.
     */
    public function getStubContents(): string
    {
        $stubFile = resource_path('stubs/vendor/mojura/controller.php.stub');
        if (! File::exists($stubFile)) {
            $stubFile = __DIR__.'/../../resources/stubs/controller.php.stub';
        }

        return File::get($stubFile);
    }
}
