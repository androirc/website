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

namespace Madalynn\Bundle\AndroBundle\Helper;

/**
 * String helper
 *
 * @author Julien Brochet <mewt@androirc.com>
 */
class StringHelper
{
    public static function slugize($text)
    {
        $text = preg_replace('/\W+/', '-', $text);
        $text = strtolower(trim($text, '-'));

        return $text;
    }
}
