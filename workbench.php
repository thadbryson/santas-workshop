<?php

require __DIR__."/vendor/autoload.php";

use TCB\SantasWorkshop\Command;
use TCB\SantasWorkshop\Command\InfoCommand;
use TCB\SantasWorkshop\Command\CreateCommand;
use TCB\SantasWorkshop\Command\BuildCommand;

use Symfony\Component\Console\Application;

define("BASE_DIR", __DIR__);

$application = new Application("Santa's Workshop", "v2");
$application->add(new InfoCommand());
$application->add(new CreateCommand());
$application->add(new BuildCommand());
$application->run();
