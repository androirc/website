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
 * File Listener
 *
 * @author Julien Brochet <mewt@androirc.com>
 */
class FileValidatorListener
{
    /**
     * Validate the form with a file
     */
    function onPostBind(DataEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data->getPath() && null === $form['file']->getData()) {
            $form['file']->addError(new FormError('You need to enter a file'));
        }
    }
}