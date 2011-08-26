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

namespace Madalynn\AdminBundle\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;

class VersionTransformer implements DataTransformerInterface
{
    public function transform($value)
    {
        if (empty($value)) {
            return '';
        }

        if (!is_string($value)) {
            throw new UnexpectedTypeException($value, 'string');
        }

        $value = str_replace('.', '', $value);

        return (int) str_pad($value, 4, '0', STR_PAD_RIGHT);
    }

    public function reverseTransform($value)
    {
        $value = trim($value, '0');

        return implode('.', str_split($value));
    }
}