<?php

namespace TCB\SantasWorkshop\Helper;

use Symfony\Component\Finder\Finder;

class Filesystem
{
    public static function filterDir($dir, $create = false)
    {
        $dir = trim($dir);        // Trim all whitespace.
        $dir = rtrim($dir, "/");  // Trim "/" from the end of path. Add another.

        // Make sure directory exists.
        if (!is_dir($dir) && $create) {
            mkdir($dir);
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

        return $file;
    }

    public static function jsonSave($file, $data)
    {
        $json = json_encode($data, JSON_FORCE_OBJECT + JSON_PRETTY_PRINT);

        return file_put_contents($file, $json);
    }

    public static function jsonOpen($file)
    {
        $json = file_get_contents($file);

        // Decode into array (true parameter)
        return json_decode(trim($json), true);
    }

    public static function getPaths($dir, $match)
    {
        $paths = array();

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