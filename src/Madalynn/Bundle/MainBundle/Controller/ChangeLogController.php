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

use Madalynn\Bundle\MainBundle\Entity\AndroircVersion;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * ChangeLog Controller
 *
 * @author Julien Brochet <mewt@androirc.com>
 */
class ChangeLogController extends AbstractController
{
    /**
     * @Route("/changelog/{version}/{theme}",
     *     name="_changelog",
     *     defaults={"theme" = "light"},
     *     requirements={"theme" = "light|dark"}
     * )
     */
    public function showAction($version, $theme)
    {
        $em   = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('MainBundle:ChangeLog');

        $version = $em->getRepository('MainBundle:AndroircVersion')
                      ->populate(AndroircVersion::create($version));

        if (null === $version) {
            throw $this->createNotFoundException('The version does not exist in the database.');
        }

        $changelog = $repo->findByVersion($version);

        return $this->render('MainBundle:ChangeLog:show.html.twig', array(
            'changelog' => $changelog,
            'theme'     => $theme,
        ));
    }
}
