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

use Madalynn\Bundle\AndroBundle\Entity\CrashReport;

class CrashReportRepository extends EntityRepository
{
    public function alreadyExist(CrashReport $crashReport)
    {
        $crashReports = $this->createQueryBuilder('c')
                             ->orderBy('c.created', 'desc')
                             ->getQuery()
                             ->getResult();

        foreach ($crashReports as $tmp) {
            if (true === $tmp->equals($crashReport)) {
                return $tmp;
            }
        }

        return false;
    }

    public function deleteAll()
    {
        $query = $this->_em->createQuery('DELETE FROM AndroBundle:CrashReport');

        return $query->execute();
    }
}
