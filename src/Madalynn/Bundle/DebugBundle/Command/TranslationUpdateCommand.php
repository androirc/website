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
use Symfony\Component\Console\Input\InputOption;

class TranslationUpdateCommand extends ContainerAwareCommand
{
    protected $urlTemplate  = 'https://www.transifex.net/api/2/project/androirc/resource/website/translation/%s';
    protected $fileTemplate = 'messages.%s.xliff';

    protected function configure()
    {
        $this->setName('androirc:translation-update')
             ->addArgument('locales', InputArgument::IS_ARRAY, 'The list of locales to update')
             ->addOption('force', null, InputOption::VALUE_NONE, 'Force the download');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $siteLocales = $this->getContainer()->getParameter('jms_i18n_routing.locales');
        $locales     = $input->getArgument('locales');
        $force       = (Boolean) $input->getOption('force');
        $transifex   = $this->getContainer()->getParameter('androirc.translations');

        if (empty($locales)) {
            $locales = $siteLocales;
        } else {
            $locales = array_intersect($locales, $siteLocales);
        }

        $output->writeln('<info>Starting update translation'.($force ? '' : ' (dry run)').'</info>');

        foreach ($locales as $locale) {
            if ('en' === $locale) {
                // Don't download the translation for English
                continue;
            }

            $output->writeln(sprintf('<comment>  > Download translation file for "%s" locale</comment>', $locale));

            $transifexLocale = $locale;
            if (isset($transifex[$locale])) {
                $transifexLocale = $transifex[$locale];
            }

            // Downloads the translation
            $json = $this->downloadTranslation($transifexLocale);

            // Just get the content
            $content = $json['content'];

            // Tweaks
            $content = str_replace("\r\n", "\n", $content);
            $content = preg_replace('/[ \t]*$/m', '', $content);
            $content = str_replace("\n\n", "\n", $content);

            $xml  = new \SimpleXMLElement($content);

            if (true === $force) {
                $path = __DIR__.'/../Resources/translations/'.sprintf($this->fileTemplate, $locale);
                $xml->saveXML($path);
            }
        }
    }

    /**
     * Downloads a translation from Transifex for a specified locale
     *
     * @param string $locale The locale to download
     *
     * @return string The response
     */
    protected function downloadTranslation($locale)
    {
        $buzz     = $this->getContainer()->get('buzz');
        $username = $this->getContainer()->getParameter('transifex_username');
        $password = $this->getContainer()->getParameter('transifex_password');
        $url      = sprintf($this->urlTemplate, $locale);

        $response = $buzz->get($url, array(
            'Authorization: Basic '.base64_encode($username.':'.$password)
        ));

        if (401 === $response->getStatusCode()) {
            throw new \InvalidArgumentException(sprintf('Unable to connect to "%s". Are you sure about the password?', $url));
        }

        return json_decode($response->getContent(), true);
    }
}
