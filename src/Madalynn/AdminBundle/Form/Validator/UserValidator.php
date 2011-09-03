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

namespace Madalynn\AdminBundle\Form\Validator;

use Symfony\Component\Form\FormValidatorInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormError;

/**
 * User Validator
 *
 * @author Julien Brochet <mewt@androirc.com>
 */
class UserValidator implements FormValidatorInterface
{
    /**
     * Validate the User form
     *
     * @param FormInterface $form
     */
    function validate(FormInterface $form)
    {
        $user = $form->getData();

        if (null === $user->getPassword() && null === $form['plainPassword']->getData()) {
            $form['plainPassword']->addError(new FormError('You need to enter a password'));
        }
    }
}