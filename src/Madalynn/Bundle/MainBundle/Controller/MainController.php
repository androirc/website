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
 * Main Controller
 *
 * @author Julien Brochet <mewt@madalynn.eu>
 */
class MainController extends AbstractController
{
    public function homepageAction()
    {
        return $this->render('MainBundle:Main:homepage.html.twig');
    }

    public function oldhomepageAction()
    {
        $em   = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('MainBundle:Article');

        $articles = $repo->getLastArticles($this->isAdmin(), 5);

        return $this->renderWithMobile('MainBundle:Main:homepage.html.twig', array(
            'articles' => $articles
        ));
    }

    public function termsAction()
    {
        return $this->render('MainBundle:Main:terms.html.twig');
    }

    public function localesAction($request)
    {
        $locales = $this->container->getParameter('jms_i18n_routing.locales');

        return $this->render('MainBundle:Main:locales.html.twig', array(
            'locales' => $locales,
            'request' => $request
        ));
    }
}
