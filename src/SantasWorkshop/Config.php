<?php

namespace TCB\SantasWorkshop;

use TCB\SantasWorkshop\Helper\Filesystem;
use TCB\SantasWorkshop\Helper\Text;

class Config
{
    protected $data = null;

    public function __construct($data = array())
    {
        $this->setData($data);
    }

    public function setData(array $data)
    {
        $this->data = $this->filterData($data);

        return $this;
    }

    protected function filterData($data)
    {
        // Check that data has "code" and "tmpl".
        foreach (["code", "tmpl"] as $param) {
            if (!array_key_exists($param, $data)) {
                throw new \Exception("Data is not valid.");
            }
        }

        // Format "code" and "tmpl" into a code type.
        $data["code"] = Text::code($data["code"]);
        $data["tmpl"] = Text::code($data["tmpl"]);

        // If there are no vars: add some.
        if (!array_key_exists("vars", $data) || !is_array($data["vars"])) {
            $data["vars"] = [];
        }

        return $data;
    }

    public function get($param = null)
    {
        if ($param === null) {
            return $this->data;
        }

        if (!array_key_exists($param, $this->data)) {
            throw new \Exception("Param {$param} not found in Config.");
        }

        return $this->data[ $param ];
    }

    public function getDir($dir)
    {
        $dir = rtrim($dir, "/");

        return Filesystem::filterDir($dir."/".$this->get("code"), true);
    }

    public static function factory($data)
    {
        return new Config($data);
    }
}