<?php

use TCB\SantasWorkshop\Config;

class ConfigTest extends \PHPUnit_Framework_TestCase
{
    protected $config = null;

    public function setUp()
    {
        $this->config = new Config(__DIR__."/input/config/");
    }

    public function testConfigDir()
    {
        $this->assertTrue(is_dir($this->config->getDir()));
        $this->assertEquals(__DIR__."/input/config/", $this->config->getDir());
    }

    protected function checkConfig($config)
    {
        $this->assertEquals("code", $config["code"]);
        $this->assertEquals("name", $config["name"]);
        $this->assertEquals("desc", $config["desc"]);
        $this->assertEquals(3, count($config['vars']));
        $this->assertEquals("test",  $config['vars']["var1"]);
        $this->assertEquals("test2", $config['vars']["var2"]);
        $this->assertEquals("test3", $config['vars']["var3"]);
    }

    /**
     * Create a new template for the project.
     */
    public function testCreateConfig()
    {
        // Check formatting code of config.
        foreach (["code1" => "code1",
                  "TE Here" => "tehere",
                  "      \t l@n 16(*    " => "l@n16(*"] as $given => $code) {
            $config = $this->config->factory($given);

            $this->assertEquals(1, count($config));
            $this->assertEquals($code, $config["code"]);
        }

        $config_2 = $this->config->factory("code");
        $config_3 = $this->config->factory("code", "name");
        $config_2A = $this->config->factory("code", "name", "");

        $this->assertEquals(1, count($config_2));
        $this->assertEquals(2, count($config_3));
        $this->assertEquals(3, count($config_2A));

        $vars = [
            "var1" => "test",
            "var2" => "test2",
            "var3" => "test3"
        ];

        $config = $this->config->factory("code", "name", "desc", $vars);

        $this->checkConfig($config);

        $this->config->save($config);

        $this->assertEquals(
            json_encode($config, JSON_PRETTY_PRINT),
            file_get_contents($this->config->getFile($config["code"]))
        );
    }

    /**
     * Get the information about the template from it's
     * config file: .santas-workshop.yaml
     */
    public function testGetTemplateInfo()
    {
        $config = $this->config->read("code");

        $this->checkConfig($config);
    }
}