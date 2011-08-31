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

class TipController extends Controller
{
    public function showAction($lang, $date = null)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $tip = null;

        if (null !== $date) {
            try {
                $date = new \DateTime($date);
            } catch (\Exception $e) {
                throw $this->createNotFoundException('Unable to parse the datetime');
            }

            $repo = $em->getRepository('Madalynn\AndroBundle\Entity\TipHoliday');
            $tip = $repo->findByDate($lang, $date);
        }

        if (null === $tip) {
            $repo = $em->getRepository('Madalynn\AndroBundle\Entity\Tip');
            $tip = $repo->getTip($lang);
        }

        if (null === $tip) {
            return new Response('No tips to display');
        }

        $response = new Response();

        $response->headers->set('X-AndroIRC', uniqid());
        $response->setContent($tip->getContent());

        return $response;
    }
}