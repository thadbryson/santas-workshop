<?php

/*
 * This file is part of the Santa's Workshop package.
 *
 * (c) Thad Bryson <thadbry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SantasWorkshop\Component;



/**
 * class SantasHelper
 *
 * Helper class for Santa's Workshop.
 *
 * @package Santa's Workshop
 * @author  Thad Bryson <thadbry@gmail.com>
 */
class SantasHelper
{
    /**
     * @param - root directory of Santa's Helper
     */
    protected $root_dir;



    /**
     * Constructor
     */
    public function __construct()
    {
        $this->root_dir = dirname(dirname(dirname(__DIR__)));
    }

    /**
     * getRootDir()
     *
     * Returns root directory of application.
     *
     * @return String - root directory of application.
     */
    public function getRootDir()
    {
        return $this->root_dir;
    }

    /**
     * getGiftsDirectory()
     *
     * Returns path of gifts directory.
     *
     * @return String - path of gifts directory.
     */
    public function getGiftsDirectory()
    {
        return $this->getRootDir() . '/gifts';
    }

    /**
     * getGiftsTemplateDirectory()
     *
     * Returns the gifts directory for a template.
     *
     * @param String $template_name - name of the template
     *
     * @return String - gifts directory for a template.
     */
    public function getGiftsTemplateDirectory($template_name)
    {
        return $this->getRootDir() . '/gifts/' . $template_name;
    }

    /**
     * getTemplatesMainDirectory()
     *
     * Returns the templates directory.
     *
     * @return String - templates directory.
     */
    public function getTemplatesMainDirectory()
    {
        return $this->getRootDir() . '/templates';
    }

    /**
     * getTemplateDirectory()
     *
     * Returns the template directory for a template.
     *
     * @param String $template_name - name of the template
     *
     * @return String - template directory for a template.
     */
    public function getTemplateDirectory($template_name)
    {
        return $this->getRootDir() . '/templates/' . $template_name;
    }

    /**
     * getTemplateCodeDirectory()
     *
     * Returns the code directory for a template.
     *
     * @param String $template_name - name of the template
     *
     * @return String - code directory for a template.
     */
    public function getTemplateCodeDirectory($template_name)
    {
        return $this->getTemplateDirectory($template_name) . '/code';
    }

    /**
     * getTemplateConfigDirectory()
     *
     * Returns the config directory for a template.
     *
     * @param String $template_name - name of the template
     *
     * @return String - config directory for a template.
     */
    public function getTemplateConfigDirectory($template_name)
    {
        return $this->getTemplateDirectory($template_name) . '/config';
    }

    /**
     * getTemplateConfig()
     *
     * Returns a config file for a template.
     *
     * @param String $template_name - name of the template
     * @param String $config_name - name of the config file (exclude extension .yml)
     *
     * @return String - config file for a template.
     */
    public function getTemplateConfig($template_name, $config_name)
    {
        return $this->getTemplateConfigDirectory($template_name) . '/' . $config_name . '.yml';
    }

    /**
     * checkDirectory()
     *
     * Checks that a directory exists.
     *
     * @param String $dir - directory path
     * @param String $error_message - error message to output
     *
     * @return boolean - Whether or not directory exists
     */
    public function checkDirectory($dir, $error_message = false)
    {
        // Check that template directory exists.
        if (!is_dir($dir)) {
            if ($error_message === false || $error_message === '' || is_numeric($error_message)) {
                $error_message = 'Directory does not exist';
            }

            throw new \Exception("{$error_message}: " . $dir);

            return false;
        }

        return true;
    }

    /**
     * checkDirectories()
     *
     * Checks that a list of directories exist.
     *
     * @param array $dirs - array of keys (error message Strings) to Strings (directories)
     *
     * @return boolean - Whether or not all directories exist
     */
    public function checkDirectories(array $dirs)
    {
        foreach ($dirs as $error_message => $dir) {
            $this->checkDirectory($dir, $error_message);
        }

        return true;
    }

    /**
     * checkFile()
     *
     * Checks that a file exists.
     *
     * @param String $file - file path
     * @param String $error_message - error message to output
     *
     * @return boolean - Whether or not file exists
     */
    public function checkFile($file, $error_message = false)
    {
        // Check that template directory exists.
        if (!is_file($file)) {
            if ($error_message === false || $error_message === '') {
                $error_message = 'File does not exist';
            }

            throw new \Exception("{$error_message}: " . $file);

            return false;
        }

        return true;
    }

    /**
     * checkFiles()
     *
     * Checks that a list of files exist.
     *
     * @param array $files - array of keys (error message Strings) to Strings (files)
     *
     * @return boolean - Whether or not all files exist
     */
    public function checkFiles(array $files)
    {
        foreach ($files as $error_message => $file) {
            $this->checkFile($file, $error_message);
        }

        return true;
    }

}
