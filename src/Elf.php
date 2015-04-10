<?php

namespace TCB\SantasWorkshop;

use TCB\SantasWorkshop\AbstractRenderingEngine;
use TCB\SantasWorkshop\RenderingEngine\Twig;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class Elf
{
    protected $renderingEngine;

    protected $templatePath;

    protected $giftPath;



    public function __construct(AbstractRenderingEngine $renderingEngine = null)
    {
        $this->finder     = new Finder();
        $this->fileSystem = new Filesystem();

        // If we weren't given a RenderingEngine: use the default Twig on.
        if ($renderingEngine === null) {
            $loader = new \Twig_Loader_Filesystem();
            $engine = new \Twig_Environment($loader);

            $renderingEngine = new Twig($engine);
        }

        $this->renderingEngine = $renderingEngine;
    }

    public function getRenderingEngine()
    {
        return $this->renderingEngine;
    }

    public function build($templatePath, $giftPath, array $vars)
    {
        // Trim ending '/' from paths.
        $this->templatePath = rtrim($templatePath, '/');
        $this->giftPath     = rtrim($giftPath, '/');

        // Validate that the Gift can be built.
        // If not an Exception is thrown.
        $this
            ->validate()
            ->prepareGift()       // Prepare Gift.
            ->render($vars)       // Run rendering system on new Gift.
            ->processExcludes()   // Change .exclude files and directories to their standard names.
        ;

        return $this;
    }

    protected function prepareGift()
    {
        // Copy Template to Gift directory.
        // Override anything that's there.
        $this->fileSystem->copy($this->giftPath, $this->templatePath, true);

        return $this;
    }

    protected function render(array $vars)
    {
        $renderExtension = $this->renderingEngine->getExtension();

        $match = '/\.' . ltrim($renderExtension, '.') . '$/';

        foreach ($this->getPaths($this->giftPath, $match) as $path) {

            $target  = rtrim($path->getRealpath(), $renderExtension);
            $content = $this->renderingEngine->render($path->getRealpath(), $vars);

            // Output rendered content to the target filepath. Do no change permissions (null).
            $this->fileSystem->dumpFile($target, $content, null);
        }

        return $this;
    }

    protected function processExcludes()
    {
        foreach ($this->getPaths($this->giftPath, '/\.exclude$/') as $path) {

            $origin = $path->getRealpath();
            $target = rtrim($origin, '.exclude');

            $this->fileSystem->rename($origin, $target);
        }

        return $this;
    }

    protected function getPaths($dir, $match)
    {
        return $this->finder->in($this->giftPath)->name('/.exclude$/');
    }

    protected function validate()
    {
        $errors = [];

        // Make sure templatePath is a file or a directory.
        if (!file_exists($this->templatePath)) {
            $errors[] = 'Template Path does not exist. Must be a file or directory.';
        }

        // Make sure giftPath is writable.
        if (!is_readable($this->templatePath)) {
            $errors[] = 'Template Path is not readable.';
        }

        // Make sure giftPath is a directory.
        if (!is_dir($this->giftPath)) {
            $errors[] = 'Gift Path is not a directory.';
        }

        // Make sure giftPath is writable.
        if (!is_writable($this->giftPath)) {
            $errors[] = 'Gift Path is not writable.';
        }

        // Ensure giftPath is empty.
        // Will have more than 2 if not empty. Always has '.' and '..' directories.
        if (count(scandir($this->giftPath)) > 2) {
            $errors[] = 'Gift Path must be empty. It is not.';
        }

        if (count($errors) > 0) {
            throw new \Exception('Exception: ' . implode("\n", $errors));
        }

        return $this;
    }
}
