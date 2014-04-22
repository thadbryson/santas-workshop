<?php

use TCB\SantasWorkshop\Templator;

class TemplatorTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->templator = new Templator(__DIR__."/input/templates");
    }

    /**
     * Set the templates/ directory for the project.
     */
    public function testSetTemplateDirectory()
    {
        $dir = $this->templator->getDir();

        $this->assertTrue(is_dir($dir));
        $this->assertEquals("TCB\\SantasWorkshop\\Templator", get_class($this->templator->setDir($dir)));

        $this->assertTrue(is_dir($this->templator->getDir()));
        $this->assertEquals(__DIR__."/input/templates/", $this->templator->getDir());
    }

    /**
     * Get all the file paths to be compiled for this template.
     *
     * Separate by: twig, exclude, other
     */
    public function testGetAllPaths()
    {
        $paths = $this->templator->getPaths();

        $this->assertEquals(1, count($paths["exclude"]), var_export($paths["exclude"], true));
        $this->assertEquals(3, count($paths["twig"]), var_export($paths["twig"], true));

        $this->assertEquals(__DIR__."/input/templates/some-directory/my.twig.exclude", $paths["exclude"][0]);

        $this->assertEquals(__DIR__."/input/templates/test.twig", $paths["twig"][0]);
        $this->assertEquals(__DIR__."/input/templates/some-directory/test2.twig", $paths["twig"][1]);
        $this->assertEquals(__DIR__."/input/templates/some-directory/test.twig", $paths["twig"][2]);
    }

}