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

/**
 * Article repository
 */
class ArticleRepository extends EntityRepository
{
    /**
     * Gets the latest articles from the database
     *
     * @param boolean $admin If the user is admin or not to also retrieve
     *                       invisible news
     * @param int     $limit The number of articles to retrieve
     *
     * @return array
     */
    public function getLatestArticles($admin = false, $limit = 10)
    {
        return $this->getQueryBuilder($admin)
                    ->setMaxResults($limit)
                    ->getQuery()
                    ->getResult();
    }

    /**
     * Finds articles by date (year and month)
     *
     * @param int $month The int value for the month (1-12)
     * @param int $year  The int value for the year (eg 2012)
     *
     * @return array
     */
    public function findByDate($month, $year)
    {
        return $this->createQueryBuilder('a')
                    ->where('MONTH(a.created) = :month')
                    ->andWhere('YEAR(a.created) = :year')
                    ->orderBy('a.created', 'ASC')
                    ->getQuery()
                    ->setParameters(array(
                        'month' => $month,
                        'year'  => $year,
                    ))
                    ->execute();
    }

    /**
     * Gets a new QueryBuilder with already some fields initialized
     *
     * @param boolean $admin If the user is an administrator or not
     *
     * @return QueryBuilder
     */
    public function getQueryBuilder($admin = false)
    {
        $query = $this->createQueryBuilder('a')
                      ->orderBy('a.created', 'desc');

        if (false === $admin) {
            $query->where('a.visible = true');
        }

        return $query;
    }

    /**
     * Gets the months for the archive layout
     *
     * @return array
     */
    public function getArchivesMonths()
    {
        $dql = 'SELECT DISTINCT MONTH(a.created) AS date_month, YEAR(a.created) AS date_year '
             . 'FROM MainBundle:Article a GROUP BY date_year, date_month '
             . 'ORDER BY date_year DESC, date_month DESC';

        return $this->getEntityManager()
                    ->createQuery($dql)
                    ->getArrayResult();
    }
}
