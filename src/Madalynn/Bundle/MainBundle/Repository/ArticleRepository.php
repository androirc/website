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

class ArticleRepository extends EntityRepository
{
    public function getLastArticles($isAdmin = false, $limit = 10)
    {
        return $this->getQueryBuilder($isAdmin)
                    ->setMaxResults($limit)
                    ->getQuery()
                    ->getResult();
    }

    public function getQueryBuilder($isAdmin = false)
    {
        $query = $this->createQueryBuilder('a')
                      ->orderBy('a.created', 'desc');

        if (false === $isAdmin) {
            $query->where('a.visible = true');
        }

        return $query;
    }
}
