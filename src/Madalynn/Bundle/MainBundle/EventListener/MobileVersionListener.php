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

namespace Madalynn\Bundle\MainBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Check if the user is coming from a mobile phone
 *
 * If the user is coming from an Android phone, this listener add
 * a 'X-AndroIRC-Mobile' header to the request
 *
 * @author Julien Brochet <mewt@androirc.com>
 */
class MobileVersionListener
{
    protected $session;

    /**
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        if (false === $this->session->has('from_mobile')) {
            $uamatches = array(
                'midp', 'j2me', 'avantg', 'android', 'docomo', 'novarra', 'palmos',
                'palmsource', '240x320', 'opwv', 'chtml', 'pda', 'windows ce',
                'mmp\/', 'blackberry', 'mib\/', 'symbian', 'wireless', 'nokia',
                'hand', 'mobi', 'phone', 'cdm', 'up\.b', 'audio', 'SIE\-', 'SEC\-',
                'samsung', 'HTC', 'mot\-', 'mitsu', 'sagem', 'sony', 'alcatel', 'lg',
                'erics', 'vx', 'NEC', 'philips', 'mmm', 'xx', 'panasonic', 'sharp',
                'wap', 'sch', 'rover', 'pocket', 'benq', 'java', 'pt', 'pg', 'vox',
                'amoi', 'bird', 'compal', 'kg', 'voda', 'sany', 'kdd', 'dbt', 'sendo', 'sgh', 'webos'
            );

            $fromMobile = false;
            foreach ($uamatches as $uamatch) {
                if (preg_match('/' . $uamatch . '/i', $request->headers->get('User-Agent'))) {
                    $fromMobile = true;
                    break;
                }
            }

            $this->session->set('from_mobile', $fromMobile);
        }

        $fromMobile = $this->session->get('from_mobile');
        $mobileVersion = 0 !== preg_match('/^m\./i', $request->getHost());

        if (true === $mobileVersion) {
            $request->headers->set('X-AndroIRC-Mobile', true);
        }

        if (true === $this->session->get('first_visit', true)) {
            // This is not his first visit anymore
            $this->session->set('first_visit', false);

            if ($fromMobile && !$mobileVersion) {
                $event->setResponse(new RedirectResponse(str_replace('www.', 'm.', $request->getUri())));
            }
        }
    }
}
