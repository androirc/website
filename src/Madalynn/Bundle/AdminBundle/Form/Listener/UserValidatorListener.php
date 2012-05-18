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

namespace Madalynn\Bundle\AdminBundle\Form\Listener;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\Event\DataEvent;

/**
 * User Validator Listener
 *
 * @author Julien Brochet <mewt@androirc.com>
 */
class UserValidatorListener
{
    /**
     * Validate the User form
     *
     * @param FormInterface $form
     */
    function onPostBind(DataEvent $event)
    {
        $user = $event->getData();
        $form = $event->getForm();

        if (null === $user->getPassword() && '' === trim($form['plainPassword']->getData())) {
            $form['plainPassword']->addError(new FormError('You need to enter a password'));
        }
    }
}