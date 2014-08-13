<?php

use TCB\SantasWorkshop\Config;
use TCB\SantasWorkshop\Configurator;

class ConfigTest extends \PHPUnit_Framework_TestCase
{
    protected $configurator = null;

    protected $vars = array(
        "var1" => "test",
        "var2" => "test2",
        "var3" => "test3"
    );

    public function setUp()
    {
        $this->configurator = new Configurator(__DIR__."/input/config/");
    }

    public function testConfigDir()
    {
        $this->assertTrue(is_dir($this->configurator->getDir()));
        $this->assertEquals(__DIR__."/input/config/", $this->configurator->getDir());
    }

    protected function checkConfig($config)
    {
        $this->assertEquals("code", $config->get("code"));

        $vars = $config->get("vars");

        $this->assertEquals(3, count($this->vars));
        $this->assertEquals("test",  $this->vars["var1"]);
        $this->assertEquals("test2", $this->vars["var2"]);
        $this->assertEquals("test3", $this->vars["var3"]);
    }

    /**
     * Create a new template for the project.
     */
    public function testCreateConfig()
    {
        $config = Config::factory(array("code" => "code", "tmpl" => "code", "vars" => $this->vars));

        $this->checkConfig($config);
    }

    /**
     * Get the information about the template from it's
     * config file: .santas-workshop.yaml
     */
    public function testGetTemplateInfo()
    {
        $config = Config::factory(array("code" => "code", "tmpl" => "code", "vars" => $this->vars));

        $this->configurator->save($config);

        $config = $this->configurator->read($config);

        $this->checkConfig($config);
    }
}
