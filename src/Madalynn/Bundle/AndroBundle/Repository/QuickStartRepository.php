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

use Madalynn\Bundle\AdminBundle\DataTransformer\VersionTransformer;

class QuickStartRepository extends EntityRepository
{
    public function findByVersion($version, $lang)
    {
        $version = VersionTransformer::reverseTransform($version);

        $query = $this->createQueryBuilder('q')
                       ->where('q.language = :lang')
                       ->andWhere('q.versionMin <= :version and :version <= q.versionMax')
                       ->setParameters(array(
                            'lang'    => $lang,
                            'version' => $version
                        ))
                        ->getQuery();

        try {
            $quickstart = $query->getSingleResult();
        } catch (\Exception $e) {
            // We have an exception if the getSingleResult return
            // 0 or more than one result ...
            return null;
        }

        return $quickstart;
    }
}