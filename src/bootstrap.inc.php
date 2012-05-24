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
 *
 *
 * @package Santa's Workshop
 * @author  Thad Bryson <thadbry@gmail.com>
 */

require_once __DIR__ . '/Symfony/Component/ClassLoader/UniversalClassLoader.php';

use Symfony\Component\ClassLoader\UniversalClassLoader;



$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
    'Symfony\\Component'        => __DIR__ . '/../src',
    'SantasWorkshop\\Component' => __DIR__ . '/../src',
));

// Twig is different. It is setup with PEAR class names.
$loader->registerPrefix('Twig_', __DIR__ . '/Symfony/Component/Twig/lib');

$loader->register();


use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;



$container = new ContainerBuilder();

// Add SantasHelper helper class to container.
$container->register('santas_helper', 'SantasWorkshop\\Component\\SantasHelper');

// Add Templator helper class to container.
$container->register('templator', 'SantasWorkshop\\Component\\Templator\\Templator');

// Add Process helper class to container.
$container->register('process', 'SantasWorkshop\\Component\\Process\\ProcessHelper');