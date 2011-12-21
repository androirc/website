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

namespace Madalynn\Bundle\AndroBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Madalynn\Bundle\AndroBundle\Entity\CrashReport;

/**
 * CrashReport Controller
 *
 * @author Julien Brochet <mewt@androirc.com>
 */
class CrashReportController extends AbstractController
{
    public function addAction(Request $request)
    {
        $phoneModel = $request->request->get('phone_model');
        $androidVersion = $request->request->get('android_version');
        $threadName = $request->request->get('thread_name');
        $errorMessage = $request->request->get('error_message');
        $callstack = $request->request->get('callstack');
        $androircVersion = $request->request->get('version', 'Unknown');

        if (!$callstack || !$phoneModel || !$androidVersion) {
            return $this->createNotFoundException('Missing arguments.');
        }

        // We check if the crash report is coming from a testing mobilephone
        if (preg_match('#sdk#', $phoneModel)) {
            return new Response('Coming from a SDK Android phone.');
        }

        $crashReport = new CrashReport();

        $crashReport->setPhoneModel($phoneModel);
        $crashReport->setAndroidVersion($androidVersion);
        $crashReport->setThreadName($threadName);
        $crashReport->setErrorMessage($errorMessage);
        $crashReport->setCallstack($callstack);
        $crashReport->setAndroircVersion($androircVersion);

        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('AndroBundle:CrashReport');

        $tmp = $repo->alreadyExist($crashReport);

        if (false !== $tmp) {
            $tmp->incCount();

            $em->persist($tmp);
            $em->flush();

            return new Response('ok');
        }

        $em->persist($crashReport);
        $em->flush();

        $message = \Swift_Message::newInstance();

        $message->setSubject(sprintf('[Crash] Rapport de crash #%s (%s)', $crashReport->getId(), $crashReport->getAndroircVersion()));
        $message->setFrom('noreply@androirc.com', 'AndroIRC');
        $message->setTo('crash@androirc.com');

        $message->setBody($this->renderView('AndroBundle:Mail:crash.html.twig', array(
            'crashReport' => $crashReport
        )));

        $this->get('mailer')->send($message);

        return new Response('ok');
    }
}