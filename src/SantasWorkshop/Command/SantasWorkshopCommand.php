<?php

/*
 * This file is part of the Santa's Workshop package.
 *
 * (c) Thad Bryson <thadbry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SantasWorkshop\Component\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Finder\Finder;



/**
 * class SantasWorkshopCommand
 *
 * Root of all commands in Santa's Workshop.
 *
 * @package Santa's Workshop
 * @author  Thad Bryson <thadbry@gmail.com>
 */
class SantasWorkshopCommand extends Command
{
    /**
     * @param $container - Dependency Injection container of entire app.
     */
    protected $container;



    /**
     * Constructor
     *
     * Need this constructor so we can set the Dependency Injection Container and name on the parent constructor.
     */
    public function __construct($container, $name)
    {
        $this->container = $container;

        parent::__construct($name);
    }

    /**
     * Writes out title of command.
     */
    protected function _writeTitle(OutputInterface $output, $title)
    {
        $output->writeln('');
        $output->writeln("***** {$title} *****");
        $output->writeln('');
    }

    /**
     * Writes an <info> line.
     */
    protected function _writeInfo($output, $line)
    {
        $output->writeln("<info>{$line}</info>");
    }

}