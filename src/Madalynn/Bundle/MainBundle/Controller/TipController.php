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

use Symfony\Component\HttpFoundation\Response;

/**
 * Tip Controller
 *
 * @author Julien Brochet <mewt@androirc.com>
 */
class TipController extends AbstractController
{
    public function showAction($lang, $date = null)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $tip = null;

        if (null !== $date) {
            try {
                $date = new \DateTime($date);

                $repo = $em->getRepository('MainBundle:TipHoliday');
                $tip = $repo->findByDate($lang, $date);
            } catch (\Exception $e) {
                // Fallback to the tip without date
            }
        }

        if (null === $tip) {
            $repo = $em->getRepository('MainBundle:Tip');
            $tip = $repo->getTip($lang);
        }

        if (null === $tip) {
            return new Response('No tips to display');
        }

        return new Response($tip->getContent());
    }
}
