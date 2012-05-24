<?php

/*
 * This file is part of the Santa's Workshop package.
 *
 * (c) Thad Bryson <thadbry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SantasWorkshop\Component\Command\Template;

use SantasWorkshop\Component\Command\Template\TemplateCommand;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;



/**
 * class TemplateCreateCommand
 *
 * Creates a new template.
 *
 * @package Santa's Workshop
 * @author  Thad Bryson <thadbry@gmail.com>
 */
class TemplateCreateCommand extends TemplateCommand
{


    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setDescription('Create a new template.')
            ->addArgument('template_name', InputArgument::REQUIRED, 'What is the name of the template?')
            ->setHelp(<<<EOF
This command takes 1 argument.

template_name: name of the new template to create.

It will create a template under the /templates directory.
EOF
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Print command title.
        $this->_writeTitle($output, 'Create a New Code Template');

        // Get the template name.
        $template_name = $input->getArgument('template_name');

        // Create the template.
        try {
            // Get target directory.
            $template_dir = $this
                ->container
                ->get('santas_helper')
                ->getTemplateDirectory($template_name)
            ;

            if (is_dir($template_dir)) {
                throw new \Exception('Template already exists: ' . $template_name);
            }

            // Create new template directory.
            mkdir($template_dir);
            mkdir($template_dir . '/code');
            mkdir($template_dir . '/config');

            // Create example template file.
            $ex_tmpl = <<<EOF
<?php

// This is an example of a var being used:
echo "{{ var1 }}\\n";

echo "{{ var2 }}\\n";

echo "{{ var3 }}\\n";
EOF;

            file_put_contents($template_dir . '/code/example_template.php.twig', $ex_tmpl);

            $this->_writeInfo($output, 'Template ' . $template_name . ' created!');
        }
        catch(Exception $e) {
            $output->writeln( $e->getMessage() );
        }

        $output->writeln('');
    }

}