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

use Madalynn\Bundle\AndroBundle\Entity\AndroircVersion;

/**
 * ChangeLog Controller
 *
 * @author Julien Brochet <mewt@androirc.com>
 */
class ChangeLogController extends AbstractController
{
    public function showAction($version)
    {
        $em   = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('AndroBundle:ChangeLog');

        $version = $em->getRepository('AndroBundle:AndroircVersion')
                      ->populate(AndroircVersion::create($version));

        if (null === $version) {
            throw $this->createNotFoundException('The version does not exist in the database.');
        }

        $changelog = $repo->findByVersion($version);

        return $this->render('AndroBundle:ChangeLog:show.html.twig', array(
            'changelog' => $changelog
        ));
    }
}