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

namespace Madalynn\Bundle\AdminBundle\Form\Validator;

use Symfony\Component\Form\FormValidatorInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormError;

/**
 * File Validator
 *
 * @author Julien Brochet <mewt@androirc.com>
 */
class FileValidator implements FormValidatorInterface
{
    /**
     * Validate the form with a file
     *
     * @param FormInterface $form
     */
    function validate(FormInterface $form)
    {
        $data = $form->getData();

        if (null === $data->getPath() && null === $form['file']->getData()) {
            $form['file']->addError(new FormError('You need to enter a file'));
        }
    }
}