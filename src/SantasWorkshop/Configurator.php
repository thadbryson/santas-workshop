<?php

namespace TCB\SantasWorkshop;

use TCB\SantasWorkshop\AbstractDirectoryAttr;
use TCB\SantasWorkshop\Config;
use TCB\SantasWorkshop\Helper\Filesystem;
use TCB\SantasWorkshop\Helper\Text;

class Configurator extends AbstractDirectoryAttr
{
    protected function getConfigFile($config)
    {
        if (!($config instanceof Config)) {
            $config = Config::factory(["code" => $config, "tmpl" => $config]);
        }

        // Ouput file to config directory.
        return $config->getFile($this->getDir());
    }

    public function save(Config $config)
    {
        $file = $this->getConfigFile($config);
        Filesystem::jsonSave($file, $config->get());

        return $file;
    }

    public function read($config)
    {
        $data = Filesystem::jsonOpen($this->getConfigFile($config));

        return Config::factory($data);
    }
}
