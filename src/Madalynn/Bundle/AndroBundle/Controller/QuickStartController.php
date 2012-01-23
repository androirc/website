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

namespace Madalynn\Bundle\AndroBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * QuickStart Controller
 *
 * @author Julien Brochet <mewt@androirc.com>
 */
class QuickStartController extends AbstractController
{
    public function showAction($version, $lang)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('AndroBundle:QuickStart');

        return $this->render('AndroBundle:QuickStart:show.html.twig', array(
            'quickstart' => $repo->findByVersion($version, $lang)
        ));
    }
}