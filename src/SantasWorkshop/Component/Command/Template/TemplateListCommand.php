<?php

/*
 * This file is part of the Santa's Workshop package.
 *
 * (c) Thad Bryson <thadbry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SantasWorkshop\Component\Command\Template;

use SantasWorkshop\Component\Command\Template\TemplateCommand;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Finder\Finder;



/**
 * class TemplateListCommand
 *
 * Lists all available templates.
 *
 * @package Santa's Workshop
 * @author  Thad Bryson <thadbry@gmail.com>
 */
class TemplateListCommand extends TemplateCommand
{


    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setDescription('List all templates.')
            ->setHelp(<<<EOF
This command has 0 arguments.

It will list all the available templates under /templates.
EOF
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Print command title.
        $this->_writeTitle($output, 'All Templates');

        // Get search directory with full path.
        $template_dir = $this
            ->container
            ->get('santas_helper')
            ->getTemplatesMainDirectory()
        ;

        // Go through each directory in search directory and list it.
        $finder = new Finder();
        $dirs   = $finder
            ->directories()     // Search directories only.
            ->depth('== 0')     // Don't recursively go through sub directories.
            ->in($template_dir)   // Search in the search directory.
            ->sortByName()      // Sort directories by ascending name.
        ;

        // Show message if there are no projects.
        if (count($dirs) == 0) {
            $this->_writeInfo($output, 'There are no templates.');
        }

        foreach($dirs as $dir) {
            // Get the last directory in the path, that's the type. The '+ 1' trims the first '/'.
            $target_dir = substr($dir, strrpos($dir, DIRECTORY_SEPARATOR) + 1);

            $this->_writeInfo($output, $target_dir);
        }

        $output->writeln('');
    }
}