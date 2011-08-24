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

namespace MDL\AndroBundle\Repository;

use Doctrine\ORM\EntityRepository;

class QuickStartRepository extends EntityRepository
{
    public function findByVersion($version, $lang)
    {
        $quickstarts = $this->createQueryBuilder('q')
                            ->where('q.language = :lang')
                            ->setParameter('lang', $lang)
                            ->getQuery()
                            ->getResult();

        foreach ($quickstarts as $quickstart) {
            if (version_compare($quickstart->getVersionMin(), $version, '<=') && version_compare($version, $quickstart->getVersionMax(), '<=')) {
                return $quickstart;
            }
        }

        return null;
    }
}