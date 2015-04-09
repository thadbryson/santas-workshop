<?php

namespace TCB\SantasWorkshop;

abstract class AbstractRenderingEngine
{
    protected $engine;



    public function __construct(\Twig_Environment $engine)
    {
        $this->engine = $engine;
    }

    public function getEngine()
    {
        return $this->engine;
    }

    abstract public function getExtension();

    abstract public function doRender($path, array $vars);

    public final function render($path, array $vars)
    {
        // Make sure path is valid. If not throw an exception.
        $this->validate($path);

        return $this->doRender($path, $vars);
    }

    private function validate($path)
    {
        $errors = [];

        // Make sure path exists.
        if (!file_exists($path)) {
            $errors[] = 'Path ' . $path . ' not found.';
        }

        // Make sure it has the required extension.
        $ext    = substr($path, -1 * strlen($ext));
        $reqExt = $this->getExtension();

        if ($ext !== $reqExt) {
            $errors[] = 'Does not have required extension.';
        }

        if (count() > 0) {
            throw new \Exception('Exception: ' . implode("\n", $errors));
        }

        return $this;
    }
}
