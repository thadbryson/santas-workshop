<?php

use TCB\SantasWorkshop\Config;
use TCB\SantasWorkshop\Giftor;

class GiftorTest extends \PHPUnit_Framework_TestCase
{
    protected function checkOuput($dir)
    {
        $this->assertTrue(is_dir($dir."some-directory"));
        $this->assertTrue(is_file($dir."some-directory/test.txt"));
        $this->assertTrue(is_file($dir."some-directory/test2.txt"));
        $this->assertTrue(is_file($dir."file.txt"));
        $this->assertTrue(is_file($dir."stuff.txt"));
        $this->assertTrue(is_file($dir."test.txt"));
    }

    public function testBuild()
    {
        $config = Config::factory([
            "code" => "code",
            "tmpl" => "tmpl",
            "vars" => [
                "var1" => "text here",
                "var2" => "more text"
            ]
        ]);

        $giftor = new Giftor(__DIR__."/output/gifts");
        $dir = $giftor->build($config, __DIR__."/input/templates");
        $this->checkOuput($dir);


    }
}
