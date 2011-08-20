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

use Madalynn\AndroBundle\Entity\Donator;
use Madalynn\AdminBundle\Form\DonatorType;

class DonatorController extends CRUDController
{
    protected function getEntityName()
    {
        return 'Donator';
    }

    protected function getForm()
    {
        return new DonatorType();
    }

    protected function getEntity()
    {
        return new Donator();
    }
}