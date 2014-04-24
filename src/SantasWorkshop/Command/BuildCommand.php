<?php

namespace TCB\SantasWorkshop\Command;

use TCB\SantasWorkshop\Configurator;
use TCB\SantasWorkshop\Giftor;
use TCB\SantasWorkshop\Command\BaseCommand;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class BuildCommand extends BaseCommand
{
    protected function configure()
    {
        $this->init("gift:build", "Build a Gift.");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->outputHeader($output, "Build a new Gift!!!");

        $code = $this->getConfigCode($input);

        $configsDir   = $this->getConfigsDir($output);
        $templatesDir = $this->getTemplatesDir($output);
        $giftsDir     = $this->getGiftsDir($output);

        $configurator = new Configurator($configsDir);
        $config       = $configurator->read($code);

        $giftor = new Giftor($giftsDir);
        $stats  = $giftor->build($config, $templatesDir);

        $this->outputTable($output, [
            ["Config",          $stats["config"]        ],
            ["Template Dir",    $stats["templatesDir"]  ],
            ["Gift Dir",        $stats["giftsDir"]      ],
            ["# Twigs",         $stats["num_twigs"]     ],
            ["# Excludes",      $stats["num_excludes"]  ]
        ]);
    }
}
