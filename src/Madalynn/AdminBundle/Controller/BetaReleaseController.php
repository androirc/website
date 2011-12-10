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

namespace Madalynn\AdminBundle\Controller;

use Madalynn\AdminBundle\Form\BetaReleaseType;

use Doctrine\ORM\QueryBuilder;

class BetaReleaseController extends CRUDController
{
    protected function getForm()
    {
        return new BetaReleaseType();
    }

    protected function getClass()
    {
        return 'Madalynn\AndroBundle\Entity\BetaRelease';
    }

    protected function filterQuery(QueryBuilder $qb)
    {
        $qb->orderBy('e.revision', 'desc');
    }
}