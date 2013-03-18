<?php

/*
 * This file is part of the Santa's Workshop package.
 *
 * (c) Thad Bryson <thadbry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SantasWorkshop\Component\Templator;

use SantasWorkshop\Component\SantasHelper;
use SantasWorkshop\Component\Process\ProcessHelper;

use Symfony\Component\Finder\Finder;



/**
 * class Templator
 *
 * Helper class for using Symfony's Twig library.
 *
 * @package Santa's Workshop
 * @author  Thad Bryson <thadbry@gmail.com>
 */
class Templator
{
    /**
     * @param $santas_helper - Helper class of app.
     */
    protected $santas_helper;



    /**
     * Constructor
     */
    public function __construct()
    {
        $this->santas_helper = new SantasHelper();

        // Setup Twig Environment
        $this->loader = new \Twig_Loader_Filesystem($this->santas_helper->getTemplatesMainDirectory());
        $this->twig   = new \Twig_Environment($this->loader);
    }

    /**
     * getTemplateVars
     *
     * Get variables in a Twig template.
     *
     * @param String $template_path - path to the template
     *
     * @return array - Variables found in all Twig templates in path
     */
    public function getTemplateVars($template_path)
    {
        // Setup Twig Environment
        $this->loader = new \Twig_Loader_Filesystem($this->santas_helper->getTemplatesMainDirectory());
        $this->twig   = new \Twig_Environment($this->loader);



        $finder = new Finder();
        $finder
            ->files()               // Find only files.
            ->in($template_path)    // Find in template path.
        ;

        $vars = array();

        foreach ($finder as $file) {
            $stream = $this->twig->tokenize(file_get_contents($file->getRealpath()));
            $token  = $stream->getCurrent();

            while ($token) {
                if ($token->getType() === \Twig_Token::NAME_TYPE) {
                    $vars[ $token->getValue() ] = '{{ ' . $token->getValue() . ' }}';
                }

                try {
                    $token = $stream->next();
                }
                catch (\Twig_Error_Syntax $e) {
                    $token = false;
                }
            }
        }

        // Sort variables by keys. Don't include in return - it would return status of ksort(), not the $vars.
        ksort($vars);

        return $vars;
    }

    /**
     * build
     *
     * Builds output files from a Twig template.
     *
     * @param String $template_path - path to the template
     * @param String $destination_path - path to put the outputed code
     * @param array $vars - variables in the Twig template
     */
    public function build($template_path, $destination_path, $vars = array())
    {
        $process_helper = new ProcessHelper();

        // Create any directories need.
        $finder_dir = new Finder();
        $finder_dir
            ->directories()
            ->in($template_path)
        ;

        foreach ($finder_dir as $dir) {
            mkdir($destination_path . '/' . $dir->getRelativePathname());
        }

        // Find all files and process them.
        $finder = new Finder();
        $finder
            ->files()               // Find only files.
            ->in($template_path)    // Find in template path.
        ;

        foreach ($finder as $file) {
            // Get name of output file.
            if (strpos($file->getRelativePathname(), '.twig') !== false) {
                $output_filename = substr($file->getRelativePathname(), 0, strrpos($file->getRelativePathname(), '.twig'));

                // Get template path relative to main templates directory.
                $template_rel_path = substr($file->getRealpath(), strlen($this->santas_helper->getTemplatesMainDirectory()));

                // Get contents of template
                file_put_contents($destination_path . '/' . $output_filename, $this->twig->render($template_rel_path, $vars));
            }
            else {
                $template_dest = $destination_path . '/' . $file->getRelativePathname();

                $process_helper->runProcess("cp '{$file->getRealpath()}' '{$template_dest}'");
            }
        }

        return true;
    }

}
