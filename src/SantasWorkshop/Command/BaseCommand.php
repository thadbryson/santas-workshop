<?php

namespace TCB\SantasWorkshop\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class BaseCommand extends Command
{
    protected function outputHeader(OutputInterface $output, $text)
    {
        $output->writeln("");
        $output->writeln(" <info>{$text}</info>");
        $output->writeln("");
    }

    protected function outputTable(OutputInterface $output, $rows)
    {
        $callback = function (&$value, $key) {
            $value = trim($value);

            if ($key == 0 && $value != "") {
                $value = "<info>".$value."</info>";
            }
        };

        foreach ($rows as &$row) {
            array_walk($row, $callback);
        }

        $table = $this->getHelperSet()->get('table');
        $table->setBorderFormat("")->setRows($rows);
        $table->render($output);

        $output->writeln("");
    }

    protected function outputConfig($output, $config)
    {
        $this->outputTable($output, [
            ["Code",     $config->get("code")],
            ["Template", $config->get("tmpl")]
        ]);
    }

    protected function ask($output, $question, $default = null)
    {
        $dialog  = $this->getHelperSet()->get('dialog');

        if ($default !== null) {
            $question .= " Default: {$default}";
        }

        return $dialog->ask($output, " ".$question." ", $default);
    }

    protected function getConfigCode(OutputInterface $output)
    {
        return $this->ask($output, "Config code?");
    }

    protected function getConfigsDir(OutputInterface $output)
    {
        return $this->ask($output, "Config Directory?", BASE_DIR."/cipos/input/configs");
    }

    protected function getTemplatesDir(OutputInterface $output)
    {
        return $this->ask($output, "Templates Directory?", BASE_DIR."/cipos/input/templates");
    }

    protected function getGiftsDir(OutputInterface $output)
    {
        return $this->ask($output, "Gifts Directory?", BASE_DIR."/cipos/output/gifts");
    }
}