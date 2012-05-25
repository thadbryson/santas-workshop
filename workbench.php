<?php

/*
 * This file is part of the Santa's Workshop package.
 *
 * (c) Thad Bryson <thadbry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Workbench console.
 *
 * @package Santa's Workshop
 * @author  Thad Bryson <thadbry@gmail.com>
 */

// Setup the bootstrap.
require_once __DIR__ . '/src/bootstrap.inc.php';


use Symfony\Component\Console\Application;

use SantasWorkshop\Component\Command\Template\TemplateCreateCommand;
use SantasWorkshop\Component\Command\Template\TemplateCreateConfigCommand;
use SantasWorkshop\Component\Command\Template\TemplateListCommand;
use SantasWorkshop\Component\Command\Template\TemplateBuildCommand;


// Setup Console.
$app = new Application("Santa's Workshop", '1.0.0-DEV');

// Add the commands to the Console.
$app->addCommands(array(
    // Template commands.
    new TemplateBuildCommand($container, 'templates:build'),                    // Create code from a template.
    new TemplateCreateCommand($container, 'templates:create'),                  // Create a template.
    new TemplateCreateConfigCommand($container, 'templates:create-config'),     // Create a config file for a template.
    new TemplateListCommand($container, 'templates:list'),                      // List available templates.
));

// Run the Console.
$app->run();

