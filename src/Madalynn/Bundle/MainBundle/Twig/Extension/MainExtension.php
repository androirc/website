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

namespace Madalynn\Bundle\MainBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Locale\Locale;
use Madalynn\Bundle\MainBundle\Entity\Article;
use Madalynn\Bundle\MainBundle\Entity\ChangeLog;

class MainExtension extends \Twig_Extension
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var \IntlDateFormatter
     */
    protected $formatter;

    /**
     * Contructor
     *
     * @param ContainerInterface $container The container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->formatter = null;
    }

    /**
     * {@inheritDoc}
     */
    public function getFilters()
    {
        return array(
            'sha1' => new \Twig_Filter_Method($this, 'sha1'),
            'md5'  => new \Twig_Filter_Method($this, 'md5')
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getFunctions()
    {
        return array(
            'article_url'      => new \Twig_Function_Method($this, 'generateArticleUrl', array('is_safe' => array('html'))),
            'path_locale'      => new \Twig_Function_Method($this, 'getPathLocale', array('is_safe' => array('html'))),
            'locales'          => new \Twig_Function_Method($this, 'getLocales'),
            'display_language' => new \Twig_Function_Method($this, 'getDisplayLanguage'),
            'archive_name'     => new \Twig_Function_Method($this, 'getArchiveName'),
            'changelog'        => new \Twig_Function_Method($this, 'displayChangelog', array('is_safe' => array('html'))),
        );
    }

    /**
     * Filter sha1
     */
    public function sha1($text)
    {
        return sha1($text);
    }

    /**
     * Filter md5
     */
    public function md5($text)
    {
        return md5($text);
    }

    public function getArchiveName($month, $year)
    {
        if (null === $this->formatter) {
            $this->formatter = new \IntlDateFormatter(
                $this->container->get('request')->getLocale(),
                \IntlDateFormatter::NONE,
                \IntlDateFormatter::NONE,
                date_default_timezone_get(),
                \IntlDateFormatter::GREGORIAN,
                'MMMM YYYY'
            );
        }

        return $this->formatter->format(new \DateTime(sprintf('%d-%d-01', $year, $month)));
    }

    /**
     * Returns the language name for a locale
     *
     * @param string $locale The locale to use for the language names
     */
    public function getDisplayLanguage($locale)
    {
        return Locale::getDisplayLanguage($locale, $locale);
    }

    /**
     * Displays a changelog
     *
     * @param ChangeLog $changelog
     */
    public function displayChangelog(ChangeLog $changelog)
    {
        return @file_get_contents($changelog->getAbsolutePath());
    }

    /**
     * Returns locales supported by the application
     *
     * @return array Locales
     */
    public function getLocales()
    {
        return $this->container->getParameter('jms_i18n_routing.locales');
    }

    /**
     * Regenerate a URI based on the current request URI, but containing the locale provided
     *
     * @param Request $request  The old request
     * @param string  $locale   The locale applied in the returned url
     * @param bool    $absolute Whether the returned url should be absolute
     *
     * @return string The current url transformed with the locale provided
     *
     * @see http://it.works-for-me.net/symfony2/2011/08/10/symfony2-generate-the-current-url-with-another-locale/
     */
    public function getPathLocale(Request $request, $locale = 'en', $absolute = false)
    {
        $id = $request->attributes->get('_route');
        $parameters = $request->attributes->all();

        if (!$id) {
            // Bug when the page does not exist (404 Not found)
            $id = 'homepage';
            unset($parameters['format']);
        }

        foreach ($parameters as $key => $val) {
            if (substr($key, 0, 1) == '_') {
                unset($parameters[$key]);
            }
        }

        $query = $request->getQueryString() ? '?' . $request->getQueryString() : '';
        $router = $this->container->get('router');

        return $router->generate($id, array_merge($parameters, array('_locale' => $locale)), $absolute) . $query;;
    }

    /**
     * Generates an article url
     *
     * @param Article $article  An article object
     * @param boolean $absolute Absolute url or not
     *
     * @return string The article url
     */
    public function generateArticleUrl(Article $article, $absolute = false)
    {
        $params = array(
            'id'   => $article->getId(),
            'slug' => $article->getSlug()
        );

        return $this->container->get('router')->generate('blog_show', $params, $absolute);
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'main';
    }
}
