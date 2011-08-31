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
use Symfony\Component\HttpFoundation\Response;

class QuickStartController extends Controller
{    
    public function showAction($version, $lang)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('AndroBundle:QuickStart');

        $quickstart = $repo->findByVersion($version, $lang);

        $response = new Response();
        $response->headers->set('X-AndroIRC', uniqid());

        return $this->render('AndroBundle:Basic:quickstart.html.twig', array(
            'quickstart' => $quickstart
        ), $response);
    }
}