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

class VersionTransformer
{
    /**
     * Tranformation : 3990 => 3.9.9
     *
     * @param type $value
     * @return type
     */
    public static function transform($value)
    {
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
    public static function reverseTransform($value)
    {
        $value = str_replace('.', '', $value);

        if (!$value) {
            return 0;
        }

        return (int) str_pad($value, 4, '0', STR_PAD_RIGHT);
    }
}