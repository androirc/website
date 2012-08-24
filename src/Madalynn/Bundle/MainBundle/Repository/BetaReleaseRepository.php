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

class BetaReleaseRepository extends EntityRepository
{
    /**
     * Returns the latest beta that can be downloaded
     *
     * @return BetaRelease|null The beta or null otherwise
     */
    public function getLatestBeta()
    {
        return $this->createQueryBuilder('b')
                    ->where('b.downloadable = true')
                    ->orderBy('b.created', 'desc')
                    ->setMaxResults(1)
                    ->getQuery()
                    ->getOneOrNullResult();
    }
}
