<?php

namespace InnoAya\Mojura\Generators;

use InnoAya\Mojura\Str;
use Exception;
use Illuminate\Support\Facades\File;

class JobGenerator extends Generator
{
    /**
     * Generate a job.
     *
     *
     * @throws Exception
     */
    public function generate(string $job, string $module, bool $queueable = false, bool $force = false): string
    {
        $job = Str::job($job);
        $module = Str::module($module);

        $directoryPath = app_path("Modules/{$module}/Jobs");
        $filename = "{$job}.php";
        $filePath = "{$directoryPath}/{$filename}";

        $this->throwIfFileExists($filePath, $force);

        $stubContents = $this->getStubContents($queueable);

        $stubContents = $this->replacePlaceholders($stubContents, [
            'namespace' => "App\\Modules\\{$module}\\Jobs",
            'job' => $job,
        ]);

        $this->generateFile($directoryPath, $filePath, $stubContents);

        return $filePath;
    }

    /**
     * Get the appropriate stub contents.
     */
    public function getStubContents(bool $queueable): string
    {
        $filePart = $queueable ? '.queueable' : '';

        $stubFile = resource_path("stubs/vendor/mojura/job$filePart.php.stub");
        if (!File::exists($stubFile)) {
            $stubFile = __DIR__ . "/../../resources/stubs/job$filePart.php.stub";
        }

        return File::get($stubFile);
    }
}
