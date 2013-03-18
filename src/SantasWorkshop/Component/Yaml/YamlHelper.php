<?php

/*
 * This file is part of the Santa's Workshop package.
 *
 * (c) Thad Bryson <thadbry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SantasWorkshop\Component\Yaml;

use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Dumper;
use Symfony\Component\Yaml\Exception\ParseException;



/**
 * class YamlHelper
 *
 * Helper class for reading and outputing YAML files.
 *
 * @package Santa's Workshop
 * @author  Thad Bryson <thadbry@gmail.com>
 */
class YamlHelper
{
    const YAML_DEPTH = 2;



    /**
     * parse()
     *
     * Parses a yaml file into an array.
     *
     * @param String $yaml_path - path to YAML file, including file name
     *
     * @return array - array of YAML file contents
     */
    public static function parse($yaml_path)
    {
        $yaml = new Parser();

        try {
            $yaml_contents = $yaml->parse(file_get_contents($yaml_path));
        }
        catch (ParseException $e) {
            return false;
        }

        return $yaml_contents;
    }

    /**
     * dump()
     *
     * Outputs a YAML file from an array.
     *
     * @param String $yaml_path - path where to put yaml file, including file name
     * @param array $yaml_contents - array of what to put in yaml file
     *
     * @param boolean - status of file_put_contents
     */
    public static function dump($yaml_path, $yaml_contents = array())
    {
        // Create example yml config file.
        $dumper = new Dumper();
        $yaml   = $dumper->dump($yaml_contents, self::YAML_DEPTH);

        return file_put_contents($yaml_path, $yaml);
    }

}
