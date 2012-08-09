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

use Symfony\Component\Finder\Finder;

/**
 * Main Controller
 *
 * @author Julien Brochet <mewt@madalynn.eu>
 */
class MainController extends AbstractController
{
    public function homepageAction()
    {
        $em   = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('MainBundle:Article');

        $articles = $repo->getLastArticles($this->isAdmin(), 5);

        return $this->renderWithMobile('MainBundle:Main:homepage.html.twig', array(
            'articles' => $articles
        ));
    }

    public function eulaAction()
    {
        return $this->renderWithMobile('MainBundle:Main:eula.html.twig');
    }

    public function screenshotsAction()
    {
        $screenshots = Finder::create()->name("device-*.png")
                                       ->in(__DIR__.'/../Resources/public/images/device')
                                       ->depth('== 0')
                                       ->sortByName();

        return $this->render('MainBundle:Main:screenshots.html.twig', array(
            'screenshots' => $screenshots
        ));
    }

    public function donateAction()
    {
        $em   = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('MainBundle:Donator');

        return $this->render('MainBundle:Main:donate.html.twig', array(
            'donators' => $repo->getDonators()
        ));
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
