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

namespace Madalynn\Bundle\AndroBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TipRepository extends EntityRepository
{
    public function getTip($lang = 'en')
    {
        $dql = 'SELECT COUNT(t) FROM AndroBundle:Tip t WHERE t.language = :lang';

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
                    ->getSingleResult();
    }
}