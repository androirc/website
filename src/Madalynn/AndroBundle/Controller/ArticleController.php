<?php

/*
 * This file is part of the AndroIRC website.
 *
 * (c) 2010-2011 Julien Brochet <mewt@androirc.com>
 * (c) 2010-2011 Sébastien Brochet <blinkseb@androirc.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Madalynn\AndroBundle\Controller;

use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;

class ArticleController extends MobileController
{
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('AndroBundle:Article');

        $article = $repo->find($id);

        if (null === $article || (false === $this->isAdmin() && false === $article->isVisible())) {
            throw $this->createNotFoundException('This article does not exist');
        }

        return $this->renderWithMobile('AndroBundle:Article:show.html.twig', array(
            'article' => $article
        ));
    }

    public function atomAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('AndroBundle:Article');

        $articles = $repo->getLastArticles(false, 20);

        return $this->render('AndroBundle:Article:atom.html.twig', array(
            'articles' => $articles
        ));
    }

    public function archivesAction($page)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('AndroBundle:Article');

        $adapter = new DoctrineORMAdapter($repo->getQueryBuilder($this->isAdmin())->getQuery(), true);
        $pager = new Pagerfanta($adapter);
        $pager->setMaxPerPage(5);

        try {
            $pager->setCurrentPage($page);
        } catch (\Exception $e) {
            throw $this->createNotFoundException('This page does not exist');
        }

        return $this->render('AndroBundle:Article:archives.html.twig', array(
            'pager' => $pager
        ));
    }
}
