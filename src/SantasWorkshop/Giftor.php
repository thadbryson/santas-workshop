<?php

namespace TCB\SantasWorkshop;

use TCB\SantasWorkshop\AbstractDirectoryAttr;
use TCB\SantasWorkshop\Config;
use TCB\SantasWorkshop\Templator;
use TCB\SantasWorkshop\Helper\Filesystem;
use TCB\SantasWorkshop\Helper\Process;

class Giftor extends AbstractDirectoryAttr
{
    public function build(Config $config, $templatesDir)
    {
        // Copy raw template.
        $templatesDir = $config->getTemplatesDir($templatesDir);
        $giftsDir     = $config->getGiftsDir($this->getDir());

        Process::execute("cp {$templatesDir}/* {$giftsDir} -r");

        $paths = [
            "twigs"    => Filesystem::getPaths($giftsDir, "/\.twig\$/"),
            "excludes" => Filesystem::getPaths($giftsDir, "/\.exclude\$/")
        ];

        foreach ($paths["excludes"] as $path) {
            Process::rename($path, ".exclude");
        }

        // Setup Twig Environment.
        $loader = new \Twig_Loader_Filesystem($giftsDir);
        $twig   = new \Twig_Environment($loader);

        foreach ($paths["twigs"] as $path) {
            $tmpl = substr($path, strlen($giftsDir));

            $template = $twig->loadTemplate($tmpl);                     // Get the template.
            $output   = $template->render($config->get("vars"));        // Get output of template with the variables ($vars).

            file_put_contents($path, $output);                          // Ouptut the contents.

            Process::rename($path, ".twig");                         // Drop the .twig from the file name.
        }

        return [
            "config"        => $config->get("code"),
            "templatesDir"  => $templatesDir,
            "giftsDir"      => $giftsDir,
            "num_twigs"     => count($paths["twigs"]),
            "num_excludes"  => count($paths["excludes"])
        ];
    }
}
