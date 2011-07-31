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

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ArticleController extends Controller
{
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('Madalynn\AndroBundle\Entity\Article');

        $article = $repo->find($id);

        if (null === $article) {
            throw $this->createNotFoundException('This article does not exist');
        }

        return $this->render('AndroBundle:Article:show.html.twig', array(
            'article' => $article
        ));
    }

    public function atomAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('Madalynn\AndroBundle\Entity\Article');

        $articles = $repo->getLastArticles(20);

        return $this->render('AndroBundle:Article:atom.html.twig', array(
            'articles' => $articles
        ));
    }
}
