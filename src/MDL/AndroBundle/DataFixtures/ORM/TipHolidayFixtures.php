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

namespace MDL\AndroBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;

use MDL\AndroBundle\Entity\TipHoliday;

class TipHolidayFixtures implements FixtureInterface
{
    public function load($em)
    {
        $tips = array(
            array(
                'lang'    => 'en',
                'day'     => 1,
                'month'   => 1,
                'content' => 'Happy new year to you !'
            ),
            array(
                'lang'    => 'fr',
                'day'     => 1,
                'month'   => 1,
                'content' => 'Bonne année :o) !'
            ),
            array(
                'lang'    => 'en',
                'day'     => 14,
                'month'   => 2,
                'content' => 'Want to be my valentine? <3'
            ),
            array(
                'lang'    => 'fr',
                'day'     => 14,
                'month'   => 2,
                'content' => 'Bonne Saint-Valentin !'
            ),
            array(
                'lang'    => 'en',
                'day'     => 27,
                'month'   => 2,
                'content' => 'It\'s AndroIRC\'s birthday today! <b>HAPPY BIRTHDAY!</b>'
            ),
            array(
                'lang'    => 'fr',
                'day'     => 27,
                'month'   => 2,
                'content' => 'C\'est l\'anniversaire de AndroIRC aujourd\'hui ! Ca se fête non ? <:o) <b>BON ANNIVERAIRE !</b>'
            ),
            array(
                'lang'    => 'en',
                'day'     => 17,
                'month'   => 3,
                'content' => 'It\'s St. Patrick\'s day, time to get some booze!'
            ),
            array(
                'lang'    => 'fr',
                'day'     => 17,
                'month'   => 3,
                'content' => 'C\'est le moment de porter du vert ! Et oui, c\'est la fête de la Saint Patrick !'
            ),
            array(
                'lang'    => 'en',
                'day'     => 31,
                'month'   => 10,
                'content' => 'Trick or treat?'
            ),
            array(
                'lang'    => 'fr',
                'day'     => 31,
                'month'   => 10,
                'content' => 'Farce ou friandise ?'
            ),
            array(
                'lang'    => 'en',
                'day'     => 25,
                'month'   => 12,
                'content' => 'We wish you a merry christmas... *sings*'
            ),
            array(
                'lang'    => 'fr',
                'day'     => 25,
                'month'   => 12,
                'content' => 'Nous vous souhaitons un joyeux Noël !'
            )
        );

        foreach ($tips as $tip) {
            $tmp = new TipHoliday();

            $tmp->setDay($tip['day']);
            $tmp->setMonth($tip['month']);

            $tmp->setLanguage($tip['lang']);
            $tmp->setContent($tip['content']);

            $em->persist($tmp);
        }

        $em->flush();
    }
}