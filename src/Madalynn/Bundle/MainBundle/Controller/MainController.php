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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
     * @Cache(public=true, smaxage="1800", maxage="1800")
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
}
