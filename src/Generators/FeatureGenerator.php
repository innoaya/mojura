<?php

namespace InnoAya\Mojura\Generators;

use InnoAya\Mojura\Str;
use Exception;
use Illuminate\Support\Facades\File;

class FeatureGenerator extends Generator
{
    /**
     * Generate a feature.
     *
     *
     * @throws Exception
     */
    public function generate(string $feature, string $module, string $directory = null, bool $force = false): string
    {
        $feature = Str::feature($feature);
        $module = Str::module($module);

        $path = $directory !== null ? "Modules/{$module}/Features/{$directory}" : "Modules/{$module}/Features";

        $directoryPath = app_path($path);
        $filename = "$feature.php";
        $filePath = "$directoryPath/$filename";

        $this->throwIfFileExists($filePath, $force);

        $stubContents = $this->getStubContents();

        $stubContents = $this->replacePlaceholders($stubContents, [
            'namespace' => $directory !== null ? "App\\Modules\\{$module}\\Features\\{$directory}" : "App\\Modules\\{$module}\\Features",
            'feature' => $feature,
        ]);

        $this->generateFile($directoryPath, $filePath, $stubContents);

        return $filePath;
    }

    /**
     * Get the appropriate stub contents.
     */
    public function getStubContents(): string
    {
        $stubFile = resource_path('stubs/feature.php.stub');
        if (!File::exists($stubFile)) {
            $stubFile = __DIR__ . '/../../resources/stubs/feature.php.stub';
        }

        return File::get($stubFile);
    }
}
