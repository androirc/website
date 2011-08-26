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
    /**
     * Tranformation : 3990 => 3.9.9
     *
     * @param type $value
     * @return type
     */
    public function transform($value)
    {
        if (null === $value) {
            return '0';
        }

        if (!is_integer($value)) {
            throw new UnexpectedTypeException($value, 'integer');
        }

        $value = trim($value, '0');

        if (!$value) {
            return '0';
        }

        return implode('.', str_split($value));
    }

    /**
     * Reverse the tranformation : 3.9.9 => 3990
     *
     * @param type $value
     * @return type
     */
    public function reverseTransform($value)
    {
        $value = str_replace('.', '', $value);

        return (int) str_pad($value, 4, '0', STR_PAD_RIGHT);
    }
}