<?php

namespace InnoAya\Mojura;

class Decorator
{
    public static function getFileGeneratedOutput(string $path): string
    {
        $path = self::getRelativePath($path);

        return "💡 [$path has been successfully generated!]";
    }

    public static function getFileGenerationErrorOutput(string $message): string
    {
        return "💡 [$message]";
    }

    public static function getDisableRoutesWarning(): string
    {
        return '💡 [Config mojura.enable_routes has been disabled and this route file wont work, you might want to enable it!]';
    }

    public static function getRelativePath(string $path): string
    {
        return ltrim(str_replace(base_path(), '', $path), '/');
    }
}
