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

use Madalynn\Bundle\AdminBundle\DataTransformer\VersionTransformer;

class ChangeLogRepository extends EntityRepository
{
    public function findByVersion($version)
    {
        $version = VersionTransformer::reverseTransform($version);

        $changelogs = $this->createQueryBuilder('c')
                           ->where('c.version <= :version')
                           ->orderBy('c.version', 'desc')
                           ->setParameter('version', $version)
                           ->getQuery()
                           ->getResult();

        if (!$changelogs) {
            return null;
        }

        // We just need the first changelog
        return $changelogs[0];
    }
}