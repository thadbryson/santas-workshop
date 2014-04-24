<?php

namespace TCB\SantasWorkshop\Command;

use TCB\SantasWorkshop\Configurator;
use TCB\SantasWorkshop\Config;
use TCB\SantasWorkshop\Command\BaseCommand;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateCommand extends BaseCommand
{
    protected function configure()
    {
        $this
            ->setName("config:create")
            ->setDescription("Create a config.")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->outputHeader($output, "Create a Config file");

        $code = $this->getConfigCode($output);
        $tmpl = $this->ask($output, "What is the template?", $code);
        $dir  = $this->getConfigsDir($output);

        $configurator = new Configurator($dir);
        $config       = Config::factory(["code" => $code, "tmpl" => $tmpl]);

        $configurator->save($config);

        $this->outputConfig($output, $config);
    }
}