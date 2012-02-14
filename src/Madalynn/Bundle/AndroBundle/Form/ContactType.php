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

namespace Madalynn\Bundle\AndroBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('name', null, array('label' => 'contact.name'));
        $builder->add('email', 'email', array('label' => 'contact.email'));
        $builder->add('content', 'textarea', array('label' => 'contact.content'));
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Madalynn\Bundle\AndroBundle\Entity\Contact'
        );
    }

    public function getName()
    {
        return 'contact';
    }
}