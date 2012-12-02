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

class AndroircVersionRepository extends AbstractVersionRepository
{
    /**
     * {@inheritdoc}
     */
    public function populate($version)
    {
        $qb = $this->getPopulateQueryBuilder($version);

        if ($version->getState()) {
            $qb->andWhere('v.state = :state');
            $qb->setParameter('state', $version->getState());
        }

        return $qb->getQuery()
                  ->getOneOrNullResult();
    }
}
