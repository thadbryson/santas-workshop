<?php

namespace TCB\SantasWorkshop\RenderingEngine;

use TCB\SantasWorkshop\AbstractRenderingEngine;

class Twig extends AbstractRenderingEngine
{


    public function getExtension()
    {
        return '.twig';
    }

    public function doRender($path, array $vars)
    {
        // Get the Template object.
        $template = $this->getEngine()->loadTemplate($path);

        // Return the rendered template.
        return $template->render($vars);
    }
}
