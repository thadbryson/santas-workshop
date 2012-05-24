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
use SantasWorkshop\Component\Templator\Templator;



class TemplatorTest extends \PHPUnit_Framework_TestCase
{
    protected $santas_helper;
    protected $templator;
    protected $template_path;
    protected $destination_path;



    protected function setUp()
    {
        $this->santas_helper = new SantasHelper();
        $this->templator     = new Templator();

        $this->template_path = $this
            ->santas_helper
            ->getTemplateCodeDirectory('unit_test')
        ;

        $this->destination_path = $this
            ->santas_helper
            ->getGiftsTemplateDirectory('unit_test')
        ;
    }

    public function testGetTemplateVars()
    {
        $vars = $this
            ->templator
            ->getTemplateVars($this->template_path);

        $this->assertTrue(isset($vars['var1']));
        $this->assertTrue(isset($vars['var2']));
        $this->assertTrue(isset($vars['var3']));
    }

    public function testBuild()
    {
        mkdir($this->destination_path);

        $status = $this
            ->templator
            ->build($this->template_path, $this->destination_path, array('var1' => '', 'var2' => '', 'var3' => ''));

        $this->assertTrue($status);

        unlink($this->destination_path . '/example_template.php');
    }
}