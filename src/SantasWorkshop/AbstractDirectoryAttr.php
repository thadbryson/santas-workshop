<?php

namespace TCB\SantasWorkshop;

use TCB\SantasWorkshop\Helper\Filesystem;

abstract class AbstractDirectoryAttr
{
    protected $dir = null;

    public function __construct($dir)
    {
        $this->setDir($dir);
    }

    public function setDir($dir)
    {
        $this->dir = Filesystem::filterDir($dir);

        return $this;
    }

    public function getDir()
    {
        return $this->dir;
    }
}
