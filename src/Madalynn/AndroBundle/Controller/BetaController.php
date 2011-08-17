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

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Madalynn\AndroBundle\Entity\BetaDownload;
use Madalynn\AndroBundle\Location;

class BetaController extends MobileController
{
    public function showAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('Madalynn\AndroBundle\Entity\BetaRelease');

        $beta = $repo->getLastBeta();

        return $this->renderWithMobile('AndroBundle:Beta:show.html.twig', array(
            'beta' => $beta
        ));
    }

    public function downloadAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('Madalynn\AndroBundle\Entity\BetaRelease');

        $beta = $repo->getLastBeta();

        if (null === $beta) {
            throw $this->createNotFoundException('There is no beta for download at the moment');
        }

        $location = new Location($request->getClientIp());
        $download = new BetaDownload();

        $download->setBetaRelease($beta);
        $download->setLocation($location->getLocation());

        $em->persist($download);
        $em->flush();

        $response = new Response(@readfile($beta->getPath()));

        $response->headers->set('Content-Type', 'application/vnd.android.package-archive');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . basename($beta->getPath()).'"');
        $response->headers->set('Content-Transfer-Encoding', 'binary');
        $response->headers->set('Content-Length', filesize($beta->getPath()));

        return $response;
    }
}