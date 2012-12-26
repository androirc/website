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

namespace Madalynn\Bundle\MainBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Blog controller
 *
 * @author Julien Brochet <mewt@androirc.com>
 */
class BlogController extends Controller
{
    /**
     * @Route("/blog", name="blog")
     * @Template
     */
    public function listAction()
    {
        $em   = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('MainBundle:Article');

        $articles = $repo->getLatestArticles(5);

        return array('articles' => $articles);
    }

    /**
     * @Route("/blog/{id}-{slug}", name="blog_show", requirements={"slug" = "[a-zA-Z1-9\-_\/]+", "id" = "^\d+$" })
     * @Template
     */
    public function showAction($id)
    {
        $em   = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('MainBundle:Article');

        $article = $repo->find($id);

        if (null === $article) {
            throw $this->createNotFoundException('This article does not exist.');
        }

        if (false === $article->isVisible()) {
            throw $this->createNotFoundException('This article is not visible at the moment.');
        }

        return array('article' => $article);
    }

    /**
     * @Route("/blog/rss", name="_blog_rss")
     * @Template("MainBundle:Blog:rss.xml.twig")
     */
    public function rssAction()
    {
        $em   = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('MainBundle:Article');

        $articles = $repo->getLatestArticles(20);

        return array('articles' => $articles);
    }

    /**
     * Generates the menu section (for archives)
     *
     * @Template
     */
    public function menuAction()
    {
        $em   = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('MainBundle:Article');

        return array('months' => $repo->getArchivesMonths());
    }

    /**
     * @Route("/blog/archives/{year}/{month}", name="blog_archives")
     * @Template
     */
    public function archivesAction($year, $month)
    {
        $em   = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('MainBundle:Article');

        $articles = $repo->findByDate($month, $year);

        if (0 === count($articles)) {
            throw $this->createNotFoundException(sprintf('Unable to find any articles for date %d-%d', $year, $month));
        }

        return array('articles' => $articles);
    }
}
