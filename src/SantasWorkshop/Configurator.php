<?php

namespace TCB\SantasWorkshop;

use TCB\SantasWorkshop\AbstractDirectoryAttr;
use TCB\SantasWorkshop\Config;
use TCB\SantasWorkshop\Helper\Filesystem;

class Configurator extends AbstractDirectoryAttr
{
    public function getFile(Config $config)
    {
        return Filesystem::filterFile($config->get("code").".json", $this->getDir());
    }

    public function save($config)
    {
        // Ouput file to config directory.
        $file = $this->getFile($config);

        Filesystem::jsonSave($file, $config->get());

        return $this;
    }

    public function read($config)
    {
        $file = $this->getFile($config);        // Get the file path.
        $data = Filesystem::jsonOpen($file);   // Get the file contents.

        return Config::factory($data);          // Return a new Config object.
    }
}
