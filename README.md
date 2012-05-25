
Santa's Workshop
================

[![Build Status](https://secure.travis-ci.org/thadbryson/santas-workshop.png)](http://travis-ci.org/thadbryson/santas-workshop)


About
-----
Santa's Workshop is a tool for creating gifts. Gifts of code. It generates
code from templates. It can create any type of code or file. Santa's
Workshop uses the Twig format.


Requirements
------------
PHP 5.3.3 or higher
PHPUnit for unit testing (optional)


Structure
---------
/gifts - Where the created code will reside.

/gifts/(template_name) - Where each built gift for a template will reside.
They will be timestamped.

/src - The source code of the Workshop.

/templates - Where the templates for the gifts go.

/templates/(template_name) - The template code and configs.

/templates/(template_name)/code - The code for the template.

/templates/(template_name)/config - The config files for templates. It has
the variables that will be for the created gift.


How to Use
----------
1. Open a command prompt.
2. Go to the root of the Santa's Workshop project.
3. Type in the following command: $ php workbench.php

That will list commands you can use. There are 4 with the Workshop.

templates:create            - Creates a new template.
templates:create-config     - Creates a config file for a template.
templates:build             - Builds the code from the template.
templates:list              - Lists all available templates.

If you run a command (Ex: $ php workbench.php templates:create) it will
show you the arguments for the command.


Special Thanks
--------------
Sensio Labs for creating the Symfony 2 Components we use in Santa's
Workshop. The components we use are:

Class Loader
Console
Dependency Injection
Finder
Process
Yaml

We also use Twig as the template engine. Twig is maintained by Sensio Labs.

PHP is our language of choice.

PHPUnit is the unit testing framework.

