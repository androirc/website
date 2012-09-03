<?php

/*
 * This file is part of the AndroIRC website.
 *
 * (c) 2010-2012 Julien Brochet <mewt@androirc.com>
 * (c) 2010-2012 Sébastien Brochet <blinkseb@androirc.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Madalynn\Bundle\DebugBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Finder\Finder;

class ChangeLogUpdateCommand extends ContainerAwareCommand
{
    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this->setName('changelog:update')
             ->addArgument('path', InputArgument::REQUIRED, 'The path to the changelogs folder');
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Creates a custom Twig environment
        $twig = new \Twig_Environment(new \Twig_Loader_String());
        $layout = <<<EOF
<ul>
{% for change in changes %}
    <li>
    {% if change.key %}
        <strong>{{ change.key }}</strong>
    {% endif %}

        {{ change.content }}
    </li>
{% endfor %}
</ul>
EOF;

        $changelogs = Finder::create()
                        ->in($input->getArgument('path'))
                        ->getIterator();

        foreach ($changelogs as $changelog) {
            $changes = $this->getChanges($changelog->getPathname());
            $html = $twig->render($layout, array('changes' => $changes));

            $output->writeln(sprintf('<info>  > Updating changelog %s...</info>', $changelog->getFilename()));

            // Override the old changelog with the new one
            file_put_contents($changelog->getPathname(), $html);
        }
    }

    /**
     * Returns changes for a changelog
     *
     * @return null if the changelog can't be loaded or the changelog
     */
    protected function getChanges($path)
    {
        $file = @file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        if (false === $file) {
            return null;
        }

        $changes = array();

        foreach ($file as $change) {
            if ('#' === substr($change, 0, 1)) {
                continue;
            }

            $pos = strpos($change, ':');

            if (false === $pos) {
                $changes[] = array(
                    'key' => '',
                    'content' => trim($change)
                );
            } else {
                list($key, $value) = explode(':', $change, 2);

                $changes[] = array(
                    'key' => $key,
                    'content' => trim($value)
                );
            }
        }

        usort($changes, array($this, 'sortChanges'));

        return $changes;
    }

    /**
     * Sorts an array of changes
     *
     * @param string $a A change
     * @param string $b A change
     *
     * @return integer
     */
    protected function sortChanges($a, $b)
    {
        return $this->typeToInteger($b['key']) - $this->typeToInteger($a['key']);
    }

    /**
     * Changes a type to an integer
     *
     * @param string $type A type (added, changed or fixed)
     *
     * @return integer An integer representation
     */
    protected function typeToInteger($type)
    {
        switch ($type) {
            case 'added':
                return 3;

            case 'changed':
                return 2;

            case 'fixed':
                return 1;

            default:
                return 0;
        }
    }
}
