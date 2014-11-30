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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Changelog controller
 *
 * @author Julien Brochet <mewt@androirc.com>
 */
class ChangeLogController extends Controller
{
    /**
     * @Cache(public=true, smaxage="604800", maxage="604800")
     * @Route("/changelog/{version}/{theme}",
     *     name="_changelog",
     *     defaults={"theme" = "light"},
     *     requirements={"theme" = "light|dark"}
     * )
     */
    public function showAction($version, $theme)
    {
        $em   = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('MainBundle:ChangeLog');

        // Check for dev version
        $dev = strpos($version, '-dev') !== false;
        if ($dev)
        {
            // Remove '-dev' suffix
            $version = str_replace('-dev', '', $version);
        }

        $version = $em->getRepository('MainBundle:AndroircVersion')
                      ->populate(AndroircVersion::create($version));

        if (null === $version) {
            if (! $dev)
            {
                throw $this->createNotFoundException('The version does not exist.');
            }
            else
            {
                // Pick a random version
                $version = $em->getRepository('MainBundle:AndroircVersion')
                              ->getRandom();

            }
        }

        $changelog = $repo->findByVersion($version);

        if ($changelog === null)
        {
            if ($dev)
            {
                // Get a random changelog
                $changelog = $repo->getRandom();
                if ($changelog === null)
                {
                    throw $this->createNotFoundException('No changelog available.');
                }
            }
            else
            {
                throw $this->createNotFoundException('No changelog found for this version.');
            }
        }

        return $this->render('MainBundle:ChangeLog:show.html.twig', array(
            'changelog' => $changelog,
            'theme'     => $theme,
        ));
    }
}
