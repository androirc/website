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

namespace Madalynn\Bundle\AdminBundle\Controller;

use Madalynn\Bundle\AdminBundle\Form\AndroidVersionType;

use Doctrine\ORM\QueryBuilder;

class AndroidVersionController extends CRUDController
{
    public function showAction($id)
    {
        throw new \BadMethodCallException('This action is not supported for this entity.');
    }

    protected function sortQuery(QueryBuilder $qb)
    {
        $qb->orderBy('e.apiLevel', 'desc');
    }

    protected function getForm()
    {
        return new AndroidVersionType();
    }

    protected function getClass()
    {
        return 'Madalynn\\Bundle\\MainBundle\\Entity\\AndroidVersion';
    }
}
