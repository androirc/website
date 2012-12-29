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

namespace Madalynn\Bundle\MainBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TipRepository extends EntityRepository
{
    /**
     * Retrieves a tip for a language
     *
     * @param string $lang The language
     *
     * @return string The tip
     */
    public function getTip($lang)
    {
        $dql = 'SELECT COUNT(t) FROM MainBundle:Tip t WHERE t.language = :lang';

        $query = $this->_em->createQuery($dql);
        $query->setParameter('lang', $lang);

        $count = $query->getSingleScalarResult();

        if ($count == 0) {
            return null;
        }

        $offset = rand(0, $count - 1);

        return $this->createQueryBuilder('t')
                    ->where('t.language = :lang')
                    ->setFirstResult($offset)
                    ->setMaxResults(1)
                    ->setParameter('lang', $lang)
                    ->getQuery()
                    ->getOneOrNullResult();
    }

    public function getTipOrStaticTip($lang = 'en')
    {
        $staticTip = $this->createQueryBuilder('t')
                          ->where('t.static = 1')
                          ->andWhere('t.language = :lang')
                          ->setMaxResults(1)
                          ->setParameter('lang', $lang)
                          ->getQuery()
                          ->getOneOrNullResult();

        if (null === $staticTip) {
            return $this->getTip($lang);
        }

        return $staticTip;
    }
}
