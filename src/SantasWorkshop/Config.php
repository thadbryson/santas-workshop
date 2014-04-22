<?php

namespace TCB\SantasWorkshop;

use TCB\SantasWorkshop\AbstractDirectoryAttr;
use TCB\SantasWorkshop\Helper\Filesystem;

class Config extends AbstractDirectoryAttr
{
    public function factory($code, $name = null, $description = null, $vars = null)
    {
        $config = [ "code" => preg_replace("/\s+/", "", strtolower($code)) ];     // Make code lowercase and remove all whitespace.

        if (is_string($name)) {
            $config["name"] = $name;
        }

        if (is_string($description)) {
            $config["desc"] = $description;
        }

        if (is_array($vars)) {
            $config["vars"] = $vars;
        }

        return $config;
    }

    public function getFile($code)
    {
        $config = $this->factory($code);

        return Filesystem::filterFile($config["code"].".json", $this->getDir());
    }

    public function save($config)
    {
        // Ouput file to config directory.
        $file = $this->getFile($config["code"]);

        Filesystem::jsonSave($file, $config);

        return $this;
    }

    public function read($code)
    {
        $file = $this->getFile($code);

        return Filesystem::jsonOpen($file);
    }
}