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

namespace Madalynn\AdminBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

use Madalynn\AdminBundle\Controller\Action\PreActionInterface;
use Madalynn\AdminBundle\Controller\Action\PostActionInterface;

class ActionListener
{
    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();
        $controller = $controller[0];

        if ($controller instanceof PreActionInterface) {
            call_user_func(array($controller, 'preAction'), $event->getRequest());
        }
    }
}