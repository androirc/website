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

use Madalynn\AndroBundle\Entity\CrashReport;

class CrashReportController extends AbstractController
{
    public function addAction(Request $request)
    {
        $phoneModel = $request->attributes->get('phone_model');
        $androidVersion = $request->attributes->get('android_version');
        $threadName = $request->attributes->get('thread_name');
        $errorMessage = $request->attributes->get('error_message');
        $callstack = $request->attributes->get('callstack');
        $androircVersion = $request->attributes->get('version', 'Unknown');

        if (!$callstack || !$phoneModel || !$androidVersion) {
            return new Response('Missing arguments.');
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