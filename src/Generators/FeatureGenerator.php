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
    public function generate(string $feature, string $module, bool $force = false): string
    {
        $feature = Str::feature($feature);
        $module = Str::module($module);

        $directoryPath = app_path("Modules/{$module}/Features");
        $filename = "$feature.php";
        $filePath = "$directoryPath/$filename";

        $this->throwIfFileExists($filePath, $force);

        $stubContents = $this->getStubContents();

        $stubContents = $this->replacePlaceholders($stubContents, [
            'namespace' => "App\\Modules\\$module\\Features",
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
