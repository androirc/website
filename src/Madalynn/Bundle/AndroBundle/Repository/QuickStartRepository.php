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

namespace Madalynn\Bundle\AndroBundle\Repository;

use Doctrine\ORM\EntityRepository;

use Madalynn\Bundle\AndroBundle\Entity\AndroircVersion;

class QuickStartRepository extends EntityRepository
{
    public function findByVersion(AndroircVersion $version, $lang)
    {
        $qb = $this->createQueryBuilder('q');

        $query = $qb->leftJoin('q.versionMin', 'vMin')
                    ->leftJoin('q.versionMax', 'vMax')
                    ->where(
                    $qb->expr()->andx(
                        'q.language = :lang',
                        'vMin.code <= :version',
                        $qb->expr()->orx(
                            'q.versionMax IS NULL',
                            $qb->expr()->andx('q.versionMax IS NOT NULL', 'vMax.code >= :version')
                        )
                    )
                )
                ->setParameters(array(
                    'lang'    => $lang,
                    'version' => $version->getCode()
                ))
                ->getQuery();

        return $query->execute();
    }
}