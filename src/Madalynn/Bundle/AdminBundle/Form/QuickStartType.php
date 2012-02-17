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

namespace Madalynn\Bundle\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class QuickStartType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('language', 'language', array('preferred_choices' => array('en', 'fr')))
                ->add('versionMin', 'text', array('label' => 'Version min'))
                ->add('versionMax', 'text', array('label' => 'Version max'))
                ->add('content', 'editor');
    }

    public function getName()
    {
        return 'admin_quick_start';
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Madalynn\Bundle\AndroBundle\Entity\QuickStart',
        );
    }
}