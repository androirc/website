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

use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * The locale extension
 *
 * @author Julien Brochet <mewt@androirc.com>
 */
class LocaleExtension extends \Twig_Extension
{
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var string
     */
    private $locales;

    /**
     * Contructor
     *
     * @param RouterInterface $router  A RouterInterface instance
     * @param string          $locales A list of available locales
     */
    public function __construct(RouterInterface $router, $locales)
    {
        $this->router  = $router;
        $this->locales = $locales;
    }

    /**
     * {@inheritDoc}
     */
    public function getFunctions()
    {
        return array(
            'path_locale'      => new \Twig_SimpleFunction('path_locale',      array($this, 'getPathLocale'), array('is_safe' => array('html'))),
            'locales'          => new \Twig_SimpleFunction('locales',         array($this, 'getLocales')),
            'display_language' => new \Twig_SimpleFunction('display_language', array($this, 'getDisplayLanguage')),
        );
    }

    /**
     * Returns the language name for a locale
     *
     * @param string $locale The locale to use for the language names
     */
    public function getDisplayLanguage($locale)
    {
        return \Locale::getDisplayLanguage($locale, $locale);
    }

    /**
     * Returns locales supported by the application
     *
     * @return array Locales
     */
    public function getLocales()
    {
        return $this->locales;
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
            if ('_' === substr($key, 0, 1) ) {
                unset($parameters[$key]);
            }
        }

        $query = $request->getQueryString() ? '?'.$request->getQueryString() : '';

        return $this->router->generate($id, array_merge($parameters, array('_locale' => $locale)), $absolute ? UrlGeneratorInterface::ABSOLUTE_PATH : UrlGeneratorInterface::RELATIVE_PATH).$query;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'locale';
    }
}
