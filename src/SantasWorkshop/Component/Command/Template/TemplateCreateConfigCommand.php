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
 * class TemplateCreateConfigCommand
 *
 * Create a config file for a template.
 *
 * @package Santa's Workshop
 * @author  Thad Bryson <thadbry@gmail.com>
 */
class TemplateCreateConfigCommand extends TemplateCommand
{


    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setDescription('Created a config file for a template.')
            ->addArgument('template_name', InputArgument::REQUIRED, 'What is the name of the template to create a config for?')
            ->addArgument('config_name', InputArgument::REQUIRED, 'What should the config file be named?')
            ->setHelp(<<<EOF
This command takes 2 arguments.

template_name: name of template to get the config file for.
config_name:   name of new config file.

A new config file will be created under /templates/template_name/config/config_name.yml
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
        $this->_writeTitle($output, 'Created a Config File for a Template');

        // Get the template name.
        $template_name = $input->getArgument('template_name');
        $config_name   = $input->getArgument('config_name');

        // Create the template.
        try {
            $template_dir = $this
                ->container
                ->get('santas_helper')
                ->getTemplateDirectory($template_name)
            ;

            // Get target directory.
            $config_dir = $this
                ->container
                ->get('santas_helper')
                ->getTemplateConfigDirectory($template_name, $config_name)
            ;

            // Check that template directory exists.
            if (!is_dir($config_dir)) {
                mkdir($config_dir);
            }

            // Get yml config file.
            $yaml_path = $config_dir . '/' . $config_name . '.yml';

            // if (is_file($yaml_path)) {
            //     throw new \Exception('Config file exists: ' . $config_name . ' for ' . $template_name);
            // }

            // Get vars in templates.
            $vars = $this
                ->container
                ->get('templator')
                ->getTemplateVars($template_dir . '/code')
            ;

            // Create config file.
            $config_contents = array(
                'template' => $template_name,
                'config'   => $config_name,
                'vars'     => $vars
            );

            YamlHelper::dump($yaml_path, $config_contents);

            $this->_writeInfo($output, 'Template Config ' . $config_name . ' created!');
        }
        catch(Exception $e) {
            $output->writeln( $e->getMessage() );
        }

        $output->writeln('');
    }

}