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

use Madalynn\Bundle\AdminBundle\Form\TipHolidayType;

class TipHolidayController extends CRUDController
{
    protected function getForm()
    {
        return new TipHolidayType();
    }

    protected function getClass()
    {
        return 'Madalynn\\Bundle\\AndroBundle\\Entity\\TipHoliday';
    }
}