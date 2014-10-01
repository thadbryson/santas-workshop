<?php

namespace TCB\SantasWorkshop\Helper;

class Process
{
    private static function execute($command, $cwd = null)
    {
        if (strpos($command, "rm ") !== false) {
            throw new \Exception("Cannot call rm command from here. Must use eraseDir().");
        }

        $process = new \Symfony\Component\Process\Process($command, $cwd);

        return $process->run();
    }

    public static function copy($copyFrom, $copyTo)
    {
        $copyFrom = rtrim($copyFrom, '/');
        $copyTo   = rtrim($copyTo, '/');

        if (!is_dir($copyFrom) || substr_count($copyFrom, DIRECTORY_SEPARATOR) <= 1) {
            throw new \Exception('No from directory: '.$copyFrom);
        }

        if (!is_dir($copyTo) || substr_count($copyTo, DIRECTORY_SEPARATOR) <= 1) {
            throw new \Exception('No to directory: '.$copyTo);
        }

        return static::execute("cp {$copyFrom}/* {$copyTo}/ -r");
    }

    public static function rename($path, $trim)
    {
        $basename = basename($path);
        $cwd      = dirname($path);

        $basename_new = substr($basename, 0, strlen($basename) - strlen($trim));

        // Make sure we can handle filenames with spaces in it.
        $basename     = str_replace(' ', "\\ ", $basename);
        $basename_new = str_replace(' ', "\\ ", $basename_new);

        return static::execute("mv {$basename} {$basename_new}", $cwd);
    }
}