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

class FileValidator extends ConstraintValidator
{
    public function validate($object, Constraint $constraint)
    {
        $file = $object->{'get'.ucfirst($constraint->fileProperty)}();
        $path = $object->{'get'.ucfirst($constraint->pathProperty)}();

        if (null === $file && null === $path) {
            $this->context->addViolationAtSubPath($constraint->fileProperty, $constraint->message);
        }
    }
}
