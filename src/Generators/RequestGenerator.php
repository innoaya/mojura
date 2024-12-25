<?php

namespace InnoAya\Mojura\Generators;

use InnoAya\Mojura\Str;
use Exception;
use Illuminate\Support\Facades\File;

class RequestGenerator extends Generator
{
    /**
     * Generate a job.
     *
     *
     * @throws Exception
     */
    public function generate(string $request, string $module, string $directory = null, bool $force = false): string
    {
        $request = Str::request($request);
        $module = Str::module($module);

        $path = $directory !== null ? "Modules/{$module}/Http/Requests/{$directory}" : "Modules/{$module}/Http/Requests";

        $directoryPath = app_path($path);
        $filename = "{$request}.php";
        $filePath = "{$directoryPath}/{$filename}";

        $this->throwIfFileExists($filePath, $force);

        $stubContents = $this->getStubContents();

        $stubContents = $this->replacePlaceholders($stubContents, [
            'namespace' => $directory !== null ? "App\\Modules\\{$module}\\Http\\Requests\\{$directory}" : "App\\Modules\\{$module}\\Http\\Requests",
            'request' => $request,
        ]);

        $this->generateFile($directoryPath, $filePath, $stubContents);

        return $filePath;
    }

    /**
     * Get the appropriate stub contents.
     */
    public function getStubContents(): string
    {
        $stubFile = resource_path('stubs/vendor/mojura/request.php.stub');
        if (!File::exists($stubFile)) {
            $stubFile = __DIR__ . '/../../resources/stubs/request.php.stub';
        }

        return File::get($stubFile);
    }
}
