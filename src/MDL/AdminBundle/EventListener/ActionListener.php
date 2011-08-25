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

namespace MDL\AdminBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

use MDL\AdminBundle\Controller\Action\PreActionInterface;
use MDL\AdminBundle\Controller\Action\PostActionInterface;

class ActionListener
{
    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        if (true === is_array($controller)) {
            $controller = $controller[0];

            if ($controller instanceof PreActionInterface) {
                call_user_func(array($controller, 'preAction'), $event->getRequest());
            }
        }
    }
}