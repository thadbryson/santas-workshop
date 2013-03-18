<?php

/*
 * This file is part of the Santa's Workshop package.
 *
 * (c) Thad Bryson <thadbry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SantasWorkshop\Component\Process;

use Symfony\Component\Process\Process;



/**
 * class ProcessHelper
 *
 * Helper class for running Processes through Symfony Component Process.
 *
 * @package Santa's Workshop
 * @author  Thad Bryson <thadbry@gmail.com>
 */
class ProcessHelper
{


    /**
     * Runs a process command.
     *
     * @param String $command - system command (Ex: "cp 'my_dir' 'new_dir'")
     */
    public function runProcess($command)
    {
        $process = new Process($command);
        $process->run();
    }

}
