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

use Madalynn\Bundle\AndroBundle\Entity\Article;

class AndroExtension extends \Twig_Extension
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getFilters()
    {
        return array(
            'sha1'       => new \Twig_Filter_Method($this, 'sha1'),
            'md5'        => new \Twig_Filter_Method($this, 'md5'),
            'strip_tags' => new \Twig_Filter_Method($this, 'stripTags', array('is_safe' => array('html'))),
        );
    }

    public function getFunctions()
    {
        return array(
            'andro_url_article'    => new \Twig_Function_Method($this, 'articleUrl', array('is_safe' => array('html'))),
            'andro_switch_version' => new \Twig_Function_Method($this, 'switchVersion', array('is_safe' => array('html'))),
            'andro_from_mobile'    => new \Twig_Function_Method($this, 'fromMobile', array('is_safe' => array('html')))
        );
    }

    public function stripTags($text)
    {
        return strip_tags($text);
    }

    public function sha1($text)
    {
        return sha1($text);
    }

    public function md5($text)
    {
        return md5($text);
    }

    public function articleUrl(Article $article, $absolute = false)
    {
        $params = array(
            'id'   => $article->getId(),
            'slug' => $article->getSlug()
        );

        return $this->container->get('router')->generate('article_show', $params, $absolute);
    }

    public function switchVersion()
    {
        $request = $this->container->get('request');
        $uri     = $request->getUri();
        $text    = '';
        $html    = '<a href="{{ link }}" class="awesome">{{ text }}</a>';

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

    public function fromMobile()
    {
        return $this->container->get('session')->get('from_mobile', false);
    }

    public function getName()
    {
        return 'andro';
    }
}