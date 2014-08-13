<?php

use TCB\SantasWorkshop\Config;
use TCB\SantasWorkshop\Giftor;

class GiftorTest extends \PHPUnit_Framework_TestCase
{
    protected function checkOuput($stats)
    {
        $this->assertEquals("code", $stats["config"]);

        $dir = $stats['templatesDir'];

        $this->assertTrue(is_dir($dir."some-directory"), $dir);
        $this->assertTrue(is_file($dir."some-directory/my.twig.exclude"));
        $this->assertTrue(is_file($dir."some-directory/test.txt.twig"));
        $this->assertTrue(is_file($dir."some-directory/test2.txt.twig"));
        $this->assertTrue(is_file($dir."file.txt"));
        $this->assertTrue(is_file($dir."stuff.txt"));
        $this->assertTrue(is_file($dir."test.txt.twig"));

        $dir = $stats['giftsDir'];

        $this->assertTrue(is_dir($dir."some-directory"));
        $this->assertTrue(is_file($dir."some-directory/my.twig"));
        $this->assertTrue(is_file($dir."some-directory/test.txt"));
        $this->assertTrue(is_file($dir."some-directory/test2.txt"));
        $this->assertTrue(is_file($dir."file.txt"));
        $this->assertTrue(is_file($dir."stuff.txt"));
        $this->assertTrue(is_file($dir."test.txt"));

        $this->assertEquals(3, $stats["num_twigs"]);
        $this->assertEquals(1, $stats["num_excludes"]);
    }

    public function testBuild()
    {
        $config = Config::factory(array(
            "code" => "code",
            "tmpl" => "code",
            "vars" => array(
                "var1" => "text here",
                "var2" => "more text"
            )
        ));

        $giftor = new Giftor(__DIR__."/output/gifts");
        $stats = $giftor->build($config, __DIR__."/input/templates");
        $this->checkOuput($stats);
    }
}
