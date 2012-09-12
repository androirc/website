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
use Madalynn\Bundle\MainBundle\Entity\AbstractVersion;

abstract class AbstractVersionRepository extends EntityRepository
{
    /**
     * Creates an Version object from the string representation
     *
     * @param AbstractVersion $version The version
     *
     * @return AbstractVersion
     */
    public function populate($version)
    {
        return $this->getPopulateQueryBuilder($version)
                    ->getQuery()
                    ->getOneOrNullResult();
    }

    /**
     * Gets the populate query builder
     *
     * @return QueryBuilder
     */
    protected function getPopulateQueryBuilder($version)
    {
        return $this->createQueryBuilder('v')
                     ->where('v.major = :major')
                     ->andWhere('v.minor = :minor')
                     ->andWhere('v.revision = :revision')
                     ->setParameters(array(
                         'major'    => $version->getMajor(),
                         'minor'    => $version->getMinor(),
                         'revision' => $version->getRevision()
                     ))
                     ->orderBy('v.code', 'desc')
                     ->setMaxResults(1);
    }
}
