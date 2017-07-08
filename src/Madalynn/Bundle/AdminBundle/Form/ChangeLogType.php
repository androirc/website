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

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangeLogType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('version', EntityType::class, array(
                    'label'         => 'backend.change_log.field.version',
                    'class'         => 'Madalynn\\Bundle\\MainBundle\\Entity\\AndroircVersion',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('v')
                                  ->orderBy('v.code', 'desc');
                    }
                ))
                ->add('file', null, array('label' => 'backend.change_log.field.file'));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Madalynn\\Bundle\\MainBundle\\Entity\\ChangeLog',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'admin_change_log';
    }
}
