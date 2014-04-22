<?php

namespace TCB\SantasWorkshop;

use TCB\SantasWorkshop\AbstractDirectoryAttr;
use TCB\SantasWorkshop\Helper\Filesystem;

class Templator extends AbstractDirectoryAttr
{
    public function getPaths()
    {
        $paths = [];
        $paths["twig"]    = Filesystem::getPaths($this->getDir(), "/\.twig\$/");
        $paths["exclude"] = Filesystem::getPaths($this->getDir(), "/\.exclude\$/");

        return $paths;
    }
}
