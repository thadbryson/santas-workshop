<?php

/*
 * This file is part of the Santa's Workshop package.
 *
 * (c) Thad Bryson <thadbry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SantasWorkshop\Component\Tests;

use SantasWorkshop\Component\Command\Template\TemplateBuildCommand;
use SantasWorkshop\Component\Command\Template\TemplateCreateCommand;
use SantasWorkshop\Component\Command\Template\TemplateCreateConfigCommand;
use SantasWorkshop\Component\Command\Template\TemplateListCommand;
use SantasWorkshop\Component\Process\ProcessHelper;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;



class TemplateCommandsTest extends \PHPUnit_Framework_TestCase
{
    const START_HEADER  = 1;

    const TEST_TEMPLATE = 'unit_test';
    const TEST_CONFIG   = 'config_test';

    protected $app;
    protected $container;



    protected function setUp()
    {
        global $container;

        $this->container = $container;

        $this->app = new Application();
        $this->app->add(new TemplateBuildCommand($this->container, 'templates:build'));
        $this->app->add(new TemplateCreateCommand($this->container, 'templates:create'));
        $this->app->add(new TemplateCreateConfigCommand($this->container, 'templates:create-config'));
        $this->app->add(new TemplateListCommand($this->container, 'templates:list'));
    }

    protected function _clearTestDirectories()
    {
        $test_dir = $this
            ->container
            ->get('santas_helper')
            ->getTemplateDirectory(self::TEST_TEMPLATE)
        ;

        if (is_dir($test_dir)) {
            $process_helper = new ProcessHelper();
            $process_helper->runProcess("rm '{$test_dir}' -rf");
        }
    }

    protected function _executeCommand($command_name, $params)
    {
        $command        = $this->app->find($command_name);
        $command_tester = new CommandTester($command);

        $params['command'] = $command->getName();

        $command_tester->execute($params);

        return $command_tester->getDisplay();
    }

    public function testCreateExecute()
    {
        $this->_clearTestDirectories();

        $display = $this->_executeCommand('templates:create', array(
            'template_name' => self::TEST_TEMPLATE
        ));

        $this->assertTrue(strpos($display, '***** Create a New Code Template *****') === self::START_HEADER);
        $this->assertTrue(strpos($display, 'Template unit_test created!') === 41);
    }

    public function testCreateConfigExecute()
    {
        $display = $this->_executeCommand('templates:create-config', array(
            'template_name' => self::TEST_TEMPLATE,
            'config_name'   => self::TEST_CONFIG
        ));

        $this->assertTrue(strpos($display, '***** Created a Config File for a Template *****') === self::START_HEADER);
        $this->assertTrue(strpos($display, 'Template Config config_test created!') === 51);
    }

    public function testBuildExecute()
    {
        $display = $this->_executeCommand('templates:build', array(
            'template_name' => self::TEST_TEMPLATE,
            'config_name'   => self::TEST_CONFIG
        ));

        $this->assertTrue(strpos($display, '***** Template Build *****') === self::START_HEADER);
        $this->assertTrue(strpos($display, 'Template unit_test built!') === 29);
    }

    public function testListExecute()
    {
        $display = $this->_executeCommand('templates:list', array());

        $this->assertTrue(strpos($display, '***** All Templates *****') === self::START_HEADER);

        // Remove gifts directory.
        $gifts_dir = $this
            ->container
            ->get('santas_helper')
            ->getGiftsTemplateDirectory(self::TEST_TEMPLATE)
        ;

        $process_helper = new ProcessHelper();
        $process_helper->runProcess("rm '{$gifts_dir}' -rf");
    }

}