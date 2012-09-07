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
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class QuickStartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('language', 'language', array(
                    'preferred_choices' => array('en', 'fr'),
                    'label'             => 'backend.quick_start.field.language'
                ))
                ->add('versionMin', 'entity', array(
                    'class' => 'Madalynn\\Bundle\\MainBundle\\Entity\\AndroircVersion',
                    'label' => 'backend.quick_start.field.version_min'
                ))
                ->add('versionMax', 'entity', array(
                    'class'    => 'Madalynn\\Bundle\\MainBundle\\Entity\\AndroircVersion',
                    'label'    => 'backend.quick_start.field.version_max',
                    'required' => false
                ))
                ->add('content', 'editor', array('label' => 'backend.quick_start.field.content'));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Madalynn\\Bundle\\MainBundle\\Entity\\QuickStart',
        ));
    }

    public function getName()
    {
        return 'admin_quick_start';
    }
}
