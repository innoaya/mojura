<?php

namespace InnoAya\Mojura\Generators;

use InnoAya\Mojura\Decorator;
use Exception;
use Illuminate\Support\Facades\File;

abstract class Generator
{
    /**
     * Replace placeholders in stubs.
     */
    public function replacePlaceholders(string $content, array $replacements): string
    {
        foreach ($replacements as $placeholder => $replacement) {
            if ($placeholder === 'namespace') {
                $replacement = str_replace('/', '\\', $replacement);
            }

            $content = str_replace("{{{$placeholder}}}", $replacement, $content);
        }

        return $content;
    }

    /**
     * Throws exception if the given file exists and force options is false.
     *
     * @throws Exception
     */
    public function throwIfFileExists(string $filePath, bool $force = false): void
    {
        if (File::exists($filePath) && !$force) {
            $path = Decorator::getRelativePath($filePath);
            throw new Exception("$path already exists!");
        }
    }

    /**
     * Generate the replaced stub contents into a file.
     */
    public function generateFile(string $directoryPath, string $filePath, string $stubContents): void
    {
        if (!File::isDirectory($directoryPath)) {
            File::makeDirectory($directoryPath, 0755, true);
        }

        File::put($filePath, $stubContents);
    }
}
