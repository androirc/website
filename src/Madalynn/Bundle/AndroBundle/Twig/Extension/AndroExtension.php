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

namespace Madalynn\Bundle\AndroBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

use Madalynn\Bundle\AndroBundle\Entity\Article;

class AndroExtension extends \Twig_Extension
{
    protected $container;

    /**
     * Contructor
     *
     * @param ContainerInterface $container The container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getFilters()
    {
        return array(
            'sha1' => new \Twig_Filter_Method($this, 'sha1'),
            'md5'  => new \Twig_Filter_Method($this, 'md5')
        );
    }

    public function getFunctions()
    {
        return array(
            'article_url'    => new \Twig_Function_Method($this, 'generateArticleUrl', array('is_safe' => array('html'))),
            'switch_version' => new \Twig_Function_Method($this, 'switchVersion', array('is_safe' => array('html'))),
            'from_mobile'    => new \Twig_Function_Method($this, 'fromMobile', array('is_safe' => array('html'))),
            'path_locale'    => new \Twig_Function_Method($this, 'getPathLocale', array('is_safe' => array('html'))),
            'locales'        => new \Twig_Function_Method($this, 'getLocales'),
            'gravatar'       => new \Twig_Function_Method($this, 'gravatar')
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

    public function gravatar($email, $size = 50, $default = 'mm')
    {
        $hash = md5(strtolower($email));

        return sprintf('http://www.gravatar.com/avatar/'.$hash.'?s='.$size.'&d='.$default);
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
     * @return string $url The current url transformed with the locale provided
     *
     * @see http://it.works-for-me.net/symfony2/2011/08/10/symfony2-generate-the-current-url-with-another-locale/
     */
    public function getPathLocale(Request $request, $locale = 'en', $absolute = false)
    {
        $id = $request->attributes->get('_route');
        $parameters = $request->attributes->all();

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
     * Generate an article url
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

        return $this->container->get('router')->generate('article_show', $params, $absolute);
    }

    /**
     * Generate the HTML link for switch web/mobile version
     *
     * @return string The HTML content
     */
    public function switchVersion()
    {
        $request = $this->container->get('request');
        $uri     = $request->getUri();
        $text    = '';
        $html    = '<a href="{{ link }}" class="btn">{{ text }}</a>';

        if (true === $request->headers->has('X-AndroIRC-Mobile')) {
            $uri = str_replace('m.', 'www.', $uri);
            $text = $this->container->get('translator')->trans('sidebar.mobile.to_web');
        } else {
            $uri = str_replace('www.', 'm.', $uri);
            $text = $this->container->get('translator')->trans('sidebar.mobile.to_mobile');
        }

        return strtr($html, array(
            '{{ link }}' => $uri,
            '{{ text }}' => $text
        ));
    }

    /**
     * Returns true if the user is comming from a mobile or not
     */
    public function fromMobile()
    {
        return $this->container->get('session')->get('from_mobile', false);
    }

    public function getName()
    {
        return 'androirc';
    }
}
