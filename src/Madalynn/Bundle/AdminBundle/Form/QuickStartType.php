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

use Madalynn\Bundle\AdminBundle\Type\EditorType;

use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\LanguageType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuickStartType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('language', LanguageType::class, array(
                    'preferred_choices' => array('en', 'fr'),
                    'label'             => 'backend.quick_start.field.language'
                ))
                ->add('versionMin', EntityType::class, array(
                    'class' => 'Madalynn\\Bundle\\MainBundle\\Entity\\AndroircVersion',
                    'label' => 'backend.quick_start.field.version_min'
                ))
                ->add('versionMax', EntityType::class, array(
                    'class'    => 'Madalynn\\Bundle\\MainBundle\\Entity\\AndroircVersion',
                    'label'    => 'backend.quick_start.field.version_max',
                    'required' => false
                ))
                ->add('content', EditorType::class, array('label' => 'backend.quick_start.field.content'));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Madalynn\\Bundle\\MainBundle\\Entity\\QuickStart',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'admin_quick_start';
    }
}
