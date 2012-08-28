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

/**
 * Main controller
 *
 * @author Julien Brochet <mewt@androirc.com>
 */
class MainController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template
     */
    public function homepageAction()
    {
        return array();
    }

    /**
     * @Route("/terms", name="terms")
     * @Template
     */
    public function termsAction()
    {
        return array();
    }

    /**
     * @Route("/support", name="support")
     * @Template
     */
    public function supportAction()
    {
        return array();
    }

    /**
     * Generates the locales section
     *
     * @param Request $request A request instance
     *
     * @Template
     */
    public function localesAction($request)
    {
        return array(
            'locales' => $this->container->getParameter('jms_i18n_routing.locales'),
            'request' => $request
        );
    }
}
