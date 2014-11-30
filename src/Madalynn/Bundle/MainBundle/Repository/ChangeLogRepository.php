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
use Madalynn\Bundle\MainBundle\Entity\AndroircVersion;

class ChangeLogRepository extends EntityRepository
{
    /**
     * Finds the first changelog according to the version
     * If the version has not a changelog, the first previous
     * changelog is returned
     *
     * @param AndroircVersion $version The AndroIRC version
     *
     * @return ChangeLog|null The right changelog or null otherwise
     */
    public function findByVersion(AndroircVersion $version)
    {
        return $this->createQueryBuilder('c')
                    ->leftJoin('c.version', 'v')
                    ->where('v.code <= :version')
                    ->orderBy('v.code', 'desc')
                    ->setParameter('version', $version->getCode())
                    ->orderBy('v.code', 'desc')
                    ->setMaxResults(1)
                    ->getQuery()
                    ->getOneOrNullResult();
    }

    public function getRandom()
    {
        $count = $this->createQueryBuilder('c')
            ->select('COUNT(c)')
            ->getQuery()
            ->getSingleScalarResult();

        if ($count <= 0)
        {
            return null;
        }

        return $this->createQueryBuilder('c')
            ->setFirstResult(mt_rand(0, $count - 1))
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleResult();
    }
}
