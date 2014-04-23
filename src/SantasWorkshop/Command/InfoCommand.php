<?php

namespace TCB\SantasWorkshop\Command;

use TCB\SantasWorkshop\Configurator;
use TCB\SantasWorkshop\Command\BaseCommand;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class InfoCommand extends BaseCommand
{
    protected function configure()
    {
        $this
            ->setName("config:info")
            ->setDescription("Get info on a Config.")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->outputHeader($output, "Read a Config file");

        $code = $this->getConfigCode($output);
        $dir  = $this->getConfigsDir($output);

        $configurator = new Configurator($dir);
        $config       = $configurator->read($code);

        $this->outputConfig($output, $config);
    }
}