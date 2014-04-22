<?php

namespace TCB\SantasWorkshop\Helper;

use Symfony\Component\Finder\Finder;

class Filesystem
{
    public static function filterDir($dir)
    {
        $dir = trim($dir);        // Trim all whitespace.
        $dir = rtrim($dir, "/");  // Trim "/" from the end of path. Add another.

        // Make sure directory exists.
        if (!is_string($dir) || !is_dir($dir)) {
            throw new \Exception("Error finding directory: {$dir}.");
        }

        return $dir."/";
    }

    public static function filterFile($file, $dir = null)
    {
        $file = trim($file);       // Trim all whitespace.
        $file = trim($file, "/");  // Trim "/" from both sides of file.

        if ($dir !== null) {
            $dir = static::filterDir($dir);

            $file = $dir.$file;
        }

        // Make sure directory exists.
        if (!is_string($file) || !is_file($file)) {
            throw new \Exception("Error finding file: {$file}.");
        }

        return $file;
    }

    public static function jsonSave($file, $data)
    {
        $json = json_encode($data, JSON_PRETTY_PRINT);

        return file_put_contents($file, $json);
    }

    public static function jsonOpen($file)
    {
        $json = file_get_contents($file);

        // Decode into array (true parameter)
        return json_decode($json, true);
    }

    public static function getPaths($dir, $match)
    {
        $paths = [];

        $finder = new Finder();
        $finder->files()            // Find only files.
               ->in($dir)           // Search in template directory.
        ;

        // Go through all found files adding the paths to the array.
        foreach ($finder->name($match) as $file) {
            $paths[] = $file->getRealpath();
        }

        return $paths;
    }
}