<?php

namespace TCB\SantasWorkshop;

use TCB\SantasWorkshop\AbstractDirectoryAttr;
use TCB\SantasWorkshop\Config;
use TCB\SantasWorkshop\Templator;
use TCB\SantasWorkshop\Helper\Filesystem;
use TCB\SantasWorkshop\Helper\Process;

class Giftor extends AbstractDirectoryAttr
{
    public function build(Config $config, $input_dir)
    {
        // Copy raw template.
        $input_dir  = $config->getDir($input_dir);
        $output_dir = $config->getDir($this->getDir());
        $output_dir = Filesystem::filterDir(rtrim($output_dir, "/")."-".time(), true);

        Process::execute("cp ./* {$output_dir} -r", $input_dir);

        $paths = [
            "twigs"    => Filesystem::getPaths($output_dir, "/\.twig\$/"),
            "excludes" => Filesystem::getPaths($output_dir, "/\.exclude\$/")
        ];

        foreach ($paths["excludes"] as $path) {
            Process::rename($path, ".exclude");
        }

        // Setup Twig Environment.
        $loader = new \Twig_Loader_Filesystem($output_dir);
        $twig   = new \Twig_Environment($loader);

        foreach ($paths["twigs"] as $path) {
            $tmpl = substr($path, strlen($output_dir));

            $template = $twig->loadTemplate($tmpl);                     // Get the template.
            $output   = $template->render($config->get("vars"));        // Get output of template with the variables ($vars).

            file_put_contents($path, $output);                          // Ouptut the contents.

            Process::rename($path, ".twig");                         // Drop the .twig from the file name.
        }

        return $output_dir;
    }
}