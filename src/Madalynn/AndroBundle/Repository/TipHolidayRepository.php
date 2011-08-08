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

namespace Madalynn\AndroBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TipHolidayRepository extends EntityRepository
{
    public function findByDate($lang, \DateTime $date)
    {
        $query = $this->createQueryBuilder('t')
                      ->where('t.language = :lang')
                      ->andWhere('t.month = :month')
                      ->andWhere('t.day = :day')
                      ->setParameter('lang', $lang)
                      ->setParameter('month', $date->format('m'))
                      ->setParameter('day', $date->format('d'))
                      ->getQuery();

        try {
            return $query->getSingleResult();
        } catch (\Exception $e) {
            return null;
        }
    }
}