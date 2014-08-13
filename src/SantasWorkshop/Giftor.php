<?php

namespace TCB\SantasWorkshop;

use TCB\SantasWorkshop\AbstractDirectoryAttr;
use TCB\SantasWorkshop\Config;
use TCB\SantasWorkshop\Helper\Filesystem;
use TCB\SantasWorkshop\Helper\Process;

class Giftor extends AbstractDirectoryAttr
{
    protected function setDirectories($templatesDir)
    {
        $this->templatesDir = $this->config->getTemplatesDir($templatesDir);
        $this->giftsDir     = $this->config->getGiftsDir($this->getDir());
    }

    protected function copyTemplate()
    {
        return Process::execute("cp {$this->templatesDir}/* {$this->giftsDir} -r");
    }

    protected function setPaths()
    {
        $this->paths = array(
            "twigs"    => Filesystem::getPaths($this->giftsDir, "/\.twig\$/"),
            "excludes" => Filesystem::getPaths($this->giftsDir, "/\.exclude\$/")
        );
    }

    protected function renameExcludes()
    {
        foreach ($this->paths["excludes"] as $path) {
            Process::rename($path, ".exclude");
        }
    }

    protected function runTwig()
    {
        // Setup Twig Environment.
        $loader = new \Twig_Loader_Filesystem($this->giftsDir);
        $twig   = new \Twig_Environment($loader);

        foreach ($this->paths["twigs"] as $path) {
            $tmpl = substr($path, strlen($this->giftsDir));

            $template = $twig->loadTemplate($tmpl);                         // Get the template.
            $output   = $template->render($this->config->get("vars"));      // Get output of template with the variables ($vars).

            file_put_contents($path, $output);                              // Ouptut the contents.

            Process::rename($path, ".twig");                                // Drop the .twig from the file name.
        }
    }

    protected function getStats()
    {
        return array(
            "config"        => $this->config->get("code"),
            "templatesDir"  => $this->templatesDir,
            "giftsDir"      => $this->giftsDir,
            "num_twigs"     => count($this->paths["twigs"]),
            "num_excludes"  => count($this->paths["excludes"])
        );
    }

    public function build(Config $config, $templatesDir)
    {
        $this->config = $config;                // Set the Config.
        $this->setDirectories($templatesDir);   // Set the directories. Templates and Gifts.
        $this->copyTemplate();                  // Copy template directory to gifts directory.
        $this->setPaths();                      // Get the paths for the .exclude and .twig files.
        $this->renameExcludes();                // Drop the .exclude from the excluded files.
        $this->runTwig();                       // Process the Twig templates.

        return $this->getStats();               // Return the statistics of this build.
    }
}
