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

/**
 * Blog controller
 *
 * @author Julien Brochet <mewt@androirc.com>
 */
class BlogController extends AbstractController
{
    public function listAction()
    {
        $em   = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('MainBundle:Article');

        $articles = $repo->getLastArticles($this->isAdmin(), 5);

        return $this->render('MainBundle:Blog:list.html.twig', array(
            'articles' => $articles
        ));
    }

    public function showAction($id)
    {
        $em   = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('MainBundle:Article');

        $article = $repo->find($id);

        if (null === $article || (false === $this->isAdmin() && false === $article->isVisible())) {
            throw $this->createNotFoundException('This article does not exist');
        }

        return $this->renderWithMobile('MainBundle:Article:show.html.twig', array(
            'article' => $article
        ));
    }

    public function rssAction()
    {
        $em   = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('MainBundle:Article');

        $articles = $repo->getLastArticles(false, 20);

        return $this->render('MainBundle:Article:atom.html.twig', array(
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
}
