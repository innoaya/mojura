<?php

namespace InnoAya\Mojura;

use Illuminate\Support\Str as LaravelStr;

class Str extends LaravelStr
{
    /**
     * Convert a value to studly caps case.
     *
     * @param  string  $value
     */
    public static function studly($value): string
    {
        return LaravelStr::studly($value);
    }

    /**
     * Convert a value to pluralize kebab case.
     */
    public static function route(string $value): string
    {
        return self::kebab(self::plural($value));
    }

    /**
     * Convert a value to directory case.
     */
    public static function directory(string $value): string
    {
        return self::lower($value);
    }

    /**
     * Determine the real name of the given name,
     * excluding the given pattern.
     *    i.e. the name: "CreateArticleFeature.php" with pattern '/Feature.php'
     *        will result in "Create Article".
     */
    public static function realName(string $name, string $pattern = '//'): string
    {
        $name = preg_replace($pattern, '', $name);

        return implode(' ', preg_split('/(?=[A-Z])/', $name, -1, PREG_SPLIT_NO_EMPTY));
    }

    /**
     * Get the given name formatted as a feature.
     *
     *    i.e. "Create Post Feature", "CreatePostFeature.php", "createPost", "createe"
     *    and many other forms will be transformed to "CreatePostFeature" which is
     *    the standard feature class name.
     */
    public static function feature(string $name): string
    {
        $parts = array_map(fn ($part) => self::studly($part), explode('/', $name));
        $feature = self::studly(preg_replace('/Feature(\.php)?$/', '', array_pop($parts)) . 'Feature');

        $parts[] = $feature;

        return implode(DIRECTORY_SEPARATOR, $parts);
    }

    /**
     * Get the given name formatted as a job.
     *
     *    i.e. "Create Post Feature", "CreatePostJob.php", "createPost",
     *    and many other forms will be transformed to "CreatePostJob" which is
     *    the standard job class name.
     *
     * @param  string  $name
     */
    public static function job($name): string
    {
        return self::studly(preg_replace('/Job(\.php)?$/', '', $name) . 'Job');
    }

    /**
     * Get the given name formatted as an operation.
     *
     *  i.e. "Create Post Operation", "CreatePostOperation.php", "createPost",
     *  and many other forms will be transformed to "CreatePostOperation" which is
     *  the standard operation class name.
     *
     * @param  string  $name
     */
    public static function operation($name): string
    {
        return self::studly(preg_replace('/Operation(\.php)?$/', '', $name) . 'Operation');
    }

    /**
     * Get the given name formatted as a service name.
     */
    public static function module(string $name): string
    {
        $normalized = self::studly($name);

        if (!str_ends_with($normalized, 'Module')) {
            $normalized .= 'Module';
        }

        return $normalized;
    }

    /**
     * Get the given name formatted as a controller name.
     *
     * @param  string  $name
     */
    public static function controller($name): string
    {
        return self::studly(preg_replace('/Controller(\.php)?$/', '', $name) . 'Controller');
    }

    /**
     * Get the given name formatted as a model.
     *
     * Model names are just CamelCase
     *
     * @param  string  $name
     */
    public static function model($name): string
    {
        return self::studly($name);
    }

    /**
     * Get the given name formatted as a policy.
     */
    public static function policy($name): string
    {
        return self::studly(preg_replace('/Policy(\.php)?$/', '', $name) . 'Policy');
    }

    /**
     * Get the given name formatted as a request.
     *
     *  i.e. "StorePostRequest.php", "storePost",
     *  and many other forms will be transformed to "StorePostRequest" which is
     *  the standard operation class name.
     *
     * @param  string  $name
     */
    public static function request($name): string
    {
        return self::studly(preg_replace('/Request(\.php)?$/', '', $name) . 'Request');
    }
}
