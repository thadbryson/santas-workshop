Santa's Workshop
================

[![Build Status](https://secure.travis-ci.org/thadbryson/santas-workshop.png)](http://travis-ci.org/thadbryson/santas-workshop)


About
-----
Santa's Workshop is a tool for creating gifts. Gifts of text.


Kinds of Gifts
--------------
1. Software - PHP, Ruby, Javascript, .NET, Python, Java, or any software.
2. Web content - HTML, CSS, lorem ipsum, instructions, etc.
3. Documents - human resources documents for new hires, instructions for new users,
legal agreements, any text.


Overview
--------
Gifts are what is outputed by the application. Which can be code or basic content.

There are two basic things you need to build a Gift.

1. Configs - Which are .json files that are stored under "/cipos/input/configs/"
Here is an example of a config file named "wp_conf.json".

{
    "code": "wp_conf",
    "tmpl": "wp_config",
    "vars": {
        "db_name": "my_db_name",
        "db_user": "my_db_user_is_cool"
    }
}

- code: The "code" variable represents the code name of the project. Also it's file name.
For this example the code is "wp_conf" which means its fileame is "wp_conf.json".
- tmpl: The "tmpl" variable is the template this project uses. Since this tmpl is "wp_config"
the template for this project is "wp_config". That template will be under
"/cipos/input/templates/wp_config".
- vars: These are the variables that get passed into any Twig templates that need to be ran.
So for this example the variable "db_name" will be output as "my_db_name" and "db_user" will
be output as "my_db_user_is_cool".

2. Templates - Templates are the files that get copied over or run through Twig
to create your gifts.

Templates are stored under "/cipos/input/templates/". This would be an example directory
structure of the template "wp_config" from above.

/wp_config
    wp_config.php.twig
    about.txt
    somefile.twig.exclude

The root directory for it "wp_config/". The template's name is "wp_config". Also the
directory name.

When the gift is created any files ending in .twig are run through the Twig template system. If the
content of that wp_config.php.twig file has something like

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', '{{ db_name }}');

/** MySQL database username */
define('DB_USER', '{{ db_user }}');

The {{ db_name }} and {{ db_user }} variables are compiled into "my_db_name" and "my_db_user_is_cool".
So the output would be

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'my_db_name');

/** MySQL database username */
define('DB_USER', 'my_db_user_is_cool');

Any files that end in .exclude are copied over to the Gift directory without being run
through the Twig templating system. The .exclude is removed. So the file "somefile.twig.exclude"
would be copied over and renamed to "somefile.twig". It's good if you have .twig files you want
copied over without being ran through the Templating system.

Any other files that don't in either .twig or .exclude are just copied over to the Gift directory.
In the example above the "about.txt" file is copied over as is.


Creating templates
------------------
You must create a template manually. There is no command line interface for that. It's simple though. Just create a
directory anywhere with the name of your template. If you want a template called "wp_config" (Wordpress config) then you
would create a directory "/wp_config". When you build the gift you can specify which directory that's in.


Launching the Workbench
-----------------------
From the command line:

$ php workbench.php

This will launch the Workbench application shell interface. From that shell you can create configs and gifts. The command
for all commands is

$ php workbench.php list

To exit the Workbench hit "Ctrl+d".


Creating configs
----------------
Command:

$ php workbench.php config:create code

The "code" argument is the code for your new config file. You will then be prompted for the following:

1. What is the template? Default: code
- The default here is "code". It will be the same name as the config.

2. Config Directory? Default: /path-to/santas-workshop/cipos/input/configs
- Then you enter the directory where the configs are kept. By default it's under /cipos/input/configs.

The config file will be created. Here is what the above example would create:

{
    "code": "code",
    "tmpl": "code",
    "vars": {

    }
}

The "vars" are empty. You will have to enter those.


Building gifts
--------------
Command:

$ php workbench.php gift:build code

Sam as config:create the "code" argument is the config code. That example will open the "code.json" config.
Then you will be prompted for some things.

1. Config Directory? Default: /path-to/santas-workshop/cipos/input/configs
- Enter the directory for the configs.

2.  Templates Directory? Default: /var/www/html/thadbryson/santas-workshop/cipos/input/templates
- Enter the directory where the templates are kept.

3. Gifts Directory? Default: /var/www/html/thadbryson/santas-workshop/cipos/output/gifts
- Enter the directory where your gift will go.

Then your gift will be created. It will read the "code.json" config from the directory given in Step 1.
Since this config has the "tmpl" as "code" it will build a gift with the template "tmpl" in the template
directory you entered in Step 2. The "gift" will be output in the gifts directory you entered in Step 3.
The directory name for your gift will be named with the concatenation of the code you gave, a "-", and
the current timestamp.


Directory and file structure
----------------------------
Here are two main directories of the application you'll need to know. There are others
but those are standard.

/cipos - Directory for input and output. Uses CIPOS architectural principles.
    /input - Any input into the system.
        /configs - Configuration files for projects.
        /templates - Template directories for projects.
    /output - Output of system.
        /gifts - Holds Gifts created by application.
/src - Source code of the application.
workbench.php - Command line interface of application.


Special thanks
==============
No man, woman, or project is an island in itself. Myself and Santa's Workshop are not
exceptions. Here is a list of things that make this project possible.

PHP
---
http://www.php.net
PHP is the open source language this project is written in. Specifically supports version
5.4 and up.

PHPUnit
-------
http://www.phpunit.de
This project utilizes PHPUnit for unit testing. In order to stay safe and efficient we
do as much unit testing as possible.

Composer
--------
https://getcomposer.org/
Composer is used for dependency management. It's used to install and update all the 3rd party
vendors libraries.

Sensio Labs
-----------
http://sensiolabs.com/en
Sensio is a major player in the PHP community. Arguably the biggest and most influential.
A lot of the components we use are Sensio projects. They are listed below.

Twig
----
http://twig.sensiolabs.org/
Templating is done with Twig. It's an easy system to learn and master. Much of its syntax is
based on PHP. Including basic String functions.

Symfony Console
---------------
http://symfony.com/doc/current/components/console/index.html
The command line interface runs off of the Symfony console.

Symfony Finder
--------------
http://symfony.com/doc/current/components/finder.html
To search the directories we use Symfony's Finder component.

Symfony Process
---------------
http://symfony.com/doc/current/components/process.html
In order to run command line processes like 'cp /some-directory/of-min/here /some-directory/target-here'
and a like we use the Process Component of Symfony. It has a lot of functionality and safeguards.
