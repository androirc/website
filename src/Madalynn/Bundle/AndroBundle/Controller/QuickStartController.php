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
 * QuickStart Controller
 *
 * @author Julien Brochet <mewt@androirc.com>
 */
class QuickStartController extends AbstractController
{
    public function showAction($version, $lang, $theme)
    {
        $em   = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('AndroBundle:QuickStart');

        $version = $em->getRepository('AndroBundle:AndroircVersion')
                      ->populate(AndroircVersion::create($version));

        if (null === $version) {
            throw $this->createNotFoundException('The version does not exist.');
        }

        $quickstart = $repo->findByVersion($version, $lang);
        if (count($quickstart) > 1) {
            $this->get('logger')->warn(sprintf('More than one quickstart found for the version "%s"', $version));
        }

        // Just get the first item
        if ($quickstart) {
            $quickstart = $quickstart[0];
        }

        return $this->render('AndroBundle:QuickStart:show.html.twig', array(
            'quickstart' => $quickstart,
            'theme'      => $theme,
        ));
    }
}
