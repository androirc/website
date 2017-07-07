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

use Madalynn\Bundle\AdminBundle\Form\QuickStartType;

class QuickStartController extends CRUDController
{
    protected function getForm()
    {
        return QuickStartType::class;
    }

    protected function getClass()
    {
        return 'Madalynn\\Bundle\\MainBundle\\Entity\\QuickStart';
    }

    public function showAction($id)
    {
        $entity = $this->getRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find QuickStart entity.');
        }

        return $this->redirect($this->generateUrl('_quickstart', array(
            'version' => $entity->getVersionMin(),
            'lang'    => $entity->getLanguage()
        )));
    }
}
