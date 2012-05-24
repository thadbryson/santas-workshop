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

use SantasWorkshop\Component\SantasHelper;



class SantasTest extends \PHPUnit_Framework_TestCase
{
    protected $santas_helper;

    protected $test_root;


    protected function setUp()
    {
        $this->santas_helper = new SantasHelper();

        $this->test_root = dirname(dirname(dirname(__DIR__)));
    }

    public function testGetRootDir()
    {
        $this->assertEquals($this->test_root, $this->santas_helper->getRootDir());
    }

    public function testGetGiftsDirectory()
    {
        $this->assertEquals($this->test_root . '/gifts', $this->santas_helper->getGiftsDirectory());
    }

    public function testGetGiftsTemplateDirectory()
    {
        $this->assertEquals($this->test_root . '/gifts/unit_test', $this->santas_helper->getGiftsTemplateDirectory('unit_test'));
    }

    public function testGetTemplatesMainDirectory()
    {
        $this->assertEquals($this->test_root . '/templates', $this->santas_helper->getTemplatesMainDirectory());
    }

    public function testGetTemplateDirectory()
    {
        $this->assertEquals($this->test_root . '/templates/unit_test', $this->santas_helper->getTemplateDirectory('unit_test'));
    }

    public function testGetTemplateCodeDirectory()
    {
        $this->assertEquals($this->test_root . '/templates/unit_test/code', $this->santas_helper->getTemplateCodeDirectory('unit_test'));
    }

    public function testGetTemplateConfigDirectory()
    {
        $this->assertEquals($this->test_root . '/templates/unit_test/config', $this->santas_helper->getTemplateConfigDirectory('unit_test'));
    }

    public function testGetTemplateConfig()
    {
        $this->assertEquals($this->test_root . '/templates/unit_test/config/config1.yml', $this->santas_helper->getTemplateConfig('unit_test', 'config1'));
    }

    public function testCheckDirectory()
    {
        $this->assertTrue($this->santas_helper->checkDirectory($this->test_root));
    }

    public function testCheckDirectories()
    {
        $this->assertTrue($this->santas_helper->checkDirectories(array(
            $this->test_root,
            $this->test_root . '/gifts',
            $this->test_root . '/src',
            $this->test_root . '/templates',
        ), false));
    }

    public function testCheckFile()
    {
        $this->assertTrue($this->santas_helper->checkFile($this->test_root . '/README.md'));
    }

    public function testCheckFiles()
    {
        $this->assertTrue($this->santas_helper->checkFiles(array(
            $this->test_root . '/LICENSE',
            $this->test_root . '/README.md',
            $this->test_root . '/phpunit.xml.dist',
            $this->test_root . '/workbench.php',
        ), false));
    }

}