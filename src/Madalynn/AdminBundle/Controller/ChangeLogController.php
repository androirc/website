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

use Madalynn\AdminBundle\Form\ChangeLogType;

class ChangeLogController extends CRUDController
{
    protected function getForm()
    {
        return new ChangeLogType();
    }

    protected function getClass()
    {
        return 'Madalynn\AndroBundle\Entity\ChangeLog';
    }

    public function showAction($id)
    {
        $entity = $this->getRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ChangeLog entity.');
        }

        return $this->redirect($this->generateUrl('changelog', array(
            'version'=> $entity->getVersion()
        )));
    }
}