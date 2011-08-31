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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MainController extends MobileController
{
    public function homepageAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('Madalynn\AndroBundle\Entity\Article');

        $articles = $repo->getLastArticles($this->isAdmin());

        return $this->renderWithMobile('AndroBundle:Main:homepage.html.twig', array(
            'articles' => $articles
        ));
    }

    public function eulaAction()
    {
        return $this->renderWithMobile('AndroBundle:Main:eula.html.twig');
    }

    public function screenshotsAction()
    {
        return $this->render('AndroBundle:Main:screenshots.html.twig');
    }

    public function donateAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('Madalynn\AndroBundle\Entity\Donator');

        $donators = $repo->getDonators();

        return $this->renderWithMobile('AndroBundle:Main:donate.html.twig', array(
            'donators' => $donators
        ));
    }
}
