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

class DonatorRepository extends EntityRepository
{
    public function getDonators()
    {
        return $this->createQueryBuilder('d')
                    ->orderBy('d.amount', 'desc')
                    ->getQuery()
                    ->getResult();
    }
}
