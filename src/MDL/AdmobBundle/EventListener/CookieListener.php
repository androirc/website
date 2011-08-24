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

namespace MDL\AdmobBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;

use MDL\AdmobBundle\Admob;

/**
 * Create a cookie when a ad is display
 *
 * @author Julien Brochet <mewt@madalynn.eu>
 */
class CookieListener
{
    protected $admob;

    public function __construct(Admob $admob)
    {
        $this->admob = $admob;
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        $request = $event->getRequest();
        $response = $event->getResponse();

        if ($this->admob->hasPixelSent() && !$request->cookies->has('admobuu')) {
            // We create the cookie
            $value = md5(uniqid(rand(), true));
            $cookie = new Cookie('admobuu', $value, mktime(0, 0, 0, 1, 1, 2038));

            $response->headers->setCookie($cookie);
            $event->setResponse($response);
        }
    }
}