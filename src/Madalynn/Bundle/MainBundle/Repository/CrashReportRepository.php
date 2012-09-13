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

use Madalynn\Bundle\MainBundle\Entity\CrashReport;

class CrashReportRepository extends EntityRepository
{
    /**
     * Checks if a CrashReport is already registered into the database
     *
     * @param CrashReport $crashReport A CrashReport instance
     *
     * @return boolean True is the report exists, false otherwise
     */
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

    /**
     * Deletes all the crash reports
     */
    public function deleteAll()
    {
        $this->getEntityManager()
             ->createQuery('DELETE FROM MainBundle:CrashReport')
             ->execute();
    }
}
