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

class MainController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepageAction()
    {
        return $this->render('MainBundle:Main:homepage.html.twig');
    }

    /**
     * @Route("/terms", name="terms")
     */
    public function termsAction()
    {
        return $this->render('MainBundle:Main:terms.html.twig');
    }

    /**
     * Generates the locales section
     *
     * @param Request $request A request instance
     */
    public function localesAction($request)
    {
        $locales = $this->container->getParameter('jms_i18n_routing.locales');

        return $this->render('MainBundle:Main:locales.html.twig', array(
            'locales' => $locales,
            'request' => $request
        ));
    }
}
