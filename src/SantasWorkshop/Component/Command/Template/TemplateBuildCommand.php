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
use SantasWorkshop\Component\Yaml\YamlHelper;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;



/**
 * class TemplateBuildCommand
 *
 * Builds a gift from a template.
 *
 * @package Santa's Workshop
 * @author  Thad Bryson <thadbry@gmail.com>
 */
class TemplateBuildCommand extends TemplateCommand
{


    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setDescription('Creates code from a template.')
            ->addArgument('template_name', InputArgument::REQUIRED, 'What is the name of the template?')
            ->addArgument('config_name', InputArgument::REQUIRED, 'What config file do you want to load?')
            ->setHelp(<<<EOF
This command takes 2 arguments.

template_name: name of the template found in /templates
config_name:   name of the config file found in /tempates/template_name/configs/config_test.yml (Ex: config_test)

This command will take all the code from /templates/template_name/code and process
it with the variables found in the config file. All code will be output in
/gifts/template_name/{date} {time}/

The output directory is in datetime format: (year)-(month)-(day) (hours):(minutes):(seconds)
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
        $this->_writeTitle($output, 'Template Build');

        $template_name = $input->getArgument('template_name');
        $config_name   = $input->getArgument('config_name');

        $gifts_dir = $this
            ->container
            ->get('santas_helper')
            ->getGiftsTemplateDirectory($template_name)
        ;

        // Create the template.
        try {
            $template_dir = $this
                ->container
                ->get('santas_helper')
                ->getTemplateDirectory($template_name)
            ;

            $config_file = $this
                ->container
                ->get('santas_helper')
                ->getTemplateConfig($template_name, $config_name)
            ;

            $this
                ->container
                ->get('santas_helper')
                ->checkDirectory($template_dir)
            ;

            $this
                ->container
                ->get('santas_helper')
                ->checkFile($config_file)
            ;

            // Check that target directory exists. If Not - create it.
            if (!is_dir($gifts_dir)) {
                mkdir($gifts_dir);
            }

            $target_dir = $gifts_dir . '/' . date('Y-m-d H:i:s');

            // Create target directory.
            mkdir($target_dir);

            // Load Config file.
            $yaml_config = YamlHelper::parse($config_file);

            $template_contents = $this
                ->container
                ->get('templator')
                ->build($template_dir . '/code', $target_dir, $yaml_config['vars'])
            ;

            $this->_writeInfo($output, 'Template ' . $template_name . ' built!');
            $this->_writeInfo($output, 'Created in: ' . $target_dir);
        }
        catch(Exception $e) {
            $output->writeln( $e->getMessage() );
        }

        $output->writeln('');
    }

}