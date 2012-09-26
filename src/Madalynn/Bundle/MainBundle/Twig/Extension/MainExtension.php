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
use Madalynn\Bundle\MainBundle\Entity\Article;
use Madalynn\Bundle\MainBundle\Entity\ChangeLog;

/**
 * The main extension
 *
 * @author Julien Brochet <mewt@androirc.com>
 */
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
            'article_url'  => new \Twig_Function_Method($this, 'getArticlePath', array('is_safe' => array('html'))),
            'archive_name' => new \Twig_Function_Method($this, 'getArchiveName'),
            'changelog'    => new \Twig_Function_Method($this, 'displayChangelog', array('is_safe' => array('html'))),
        );
    }

    /**
     * SHA1 filter
     *
     * @param string $text The input text
     */
    public function sha1($text)
    {
        return sha1($text);
    }

    /**
     * MD5 filter
     *
     * @param string $text The input text
     */
    public function md5($text)
    {
        return md5($text);
    }

    /**
     * Gets a month name based on the current locale
     *
     * @param int $month The month
     * @param int $year  The year
     *
     * @return string The month text representation
     */
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

        return $this->formatter->format(strtotime(sprintf('%d-%d-01', $year, $month)));
    }

    /**
     * Displays a changelog
     *
     * @param ChangeLog $changelog
     */
    public function displayChangelog(ChangeLog $changelog)
    {
        return $changelog->getChanges();
    }

    /**
     * Gets an article path
     *
     * @param Article $article  An article object
     * @param boolean $absolute Absolute url or not
     *
     * @return string The article url
     */
    public function getArticlePath(Article $article, $absolute = false)
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
