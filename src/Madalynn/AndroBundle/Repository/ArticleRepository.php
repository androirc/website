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

namespace Madalynn\AndroBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ArticleRepository extends EntityRepository
{
    public function getLastArticles($limit = 10)
    {
        return $this->createQueryBuilder('a')
                    ->where('a.is_visible = true')
                    ->orderBy('a.created', 'desc')
                    ->setMaxResults($limit)
                    ->getQuery()
                    ->getResult();
    }
}