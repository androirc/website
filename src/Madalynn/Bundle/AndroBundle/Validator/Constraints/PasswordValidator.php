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

namespace Madalynn\Bundle\AndroBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PasswordValidator extends ConstraintValidator
{
    public function validate($object, Constraint $constraint)
    {
        $password      = $object->{'get'.ucfirst($constraint->passwordProperty)}();
        $plainPassword = $object->{'get'.ucfirst($constraint->plainPasswordProperty)}();

        if (null === $password && '' === trim($plainPassword)) {
            $this->context->addViolationAtSubPath($constraint->plainPasswordProperty, $constraint->message);

            return false;
        }

        return true;
    }
}
