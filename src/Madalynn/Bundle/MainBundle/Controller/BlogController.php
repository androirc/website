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

/**
 * @Route("/blog")
 */
class BlogController extends AbstractController
{
    /**
     * @Route("/", name="blog")
     */
    public function listAction()
    {
        $em   = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('MainBundle:Article');

        $articles = $repo->getLatestArticles($this->isAdmin(), 5);

        return $this->render('MainBundle:Blog:list.html.twig', array(
            'articles' => $articles
        ));
    }

    /**
     * @Route("/{id}/{slug}", name="blog_show")
     */
    public function showAction($id)
    {
        $em   = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('MainBundle:Article');

        $article = $repo->find($id);

        if (null === $article) {
            throw $this->createNotFoundException('This article does not exist');
        }

        return $this->render('MainBundle:Blog:show.html.twig', array(
            'article' => $article
        ));
    }

    /**
     * @Route("/rss", name="_blog_rss")
     */
    public function rssAction()
    {
        $em   = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('MainBundle:Article');

        $articles = $repo->getLatestArticles(false, 20);

        return $this->render('MainBundle:Blog:rss.xml.twig', array(
            'articles' => $articles
        ));
    }

    /**
     * Generates the menu section (for archives)
     */
    public function menuAction()
    {
        $em   = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('MainBundle:Article');

        return $this->render('MainBundle:Blog:menu.html.twig', array(
            'months' => $repo->getArchivesMonths()
        ));
    }

    /**
     * @Route("/archives/{year}/{month}", name="blog_archives")
     */
    public function archivesAction($year, $month)
    {
        $em   = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('MainBundle:Article');

        $articles = $repo->findByDate($month, $year);

        if (0 === count($articles)) {
            throw $this->createNotFoundException(sprintf('Unable to find any articles for date %d-%d', $year, $month));
        }

        return $this->render('MainBundle:Blog:archives.html.twig', array(
            'articles' => $articles
        ));
    }
}
