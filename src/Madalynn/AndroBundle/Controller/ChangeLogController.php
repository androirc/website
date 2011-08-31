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

class ChangeLogController extends Controller
{
    public function showAction($version)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('AndroBundle:ChangeLog');

        $changelog = $repo->findByVersion($version);

        return $this->render('AndroBundle:ChangeLog:show.html.twig', array(
            'changelog' => $changelog
        ));
    }
}