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

class BlogController extends AbstractController
{
    public function listAction()
    {
        $em   = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('MainBundle:Article');

        $articles = $repo->getLatestArticles($this->isAdmin(), 5);

        return $this->render('MainBundle:Blog:list.html.twig', array(
            'articles' => $articles
        ));
    }

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

    public function rssAction()
    {
        $em   = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('MainBundle:Article');

        $articles = $repo->getLatestArticles(false, 20);

        return $this->render('MainBundle:Blog:rss.xml.twig', array(
            'articles' => $articles
        ));
    }

    public function menuAction()
    {
        $em   = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('MainBundle:Article');

        return $this->render('MainBundle:Blog:menu.html.twig', array(
            'months' => $repo->getArchivesMonths()
        ));
    }

    public function archivesAction($month, $year)
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
