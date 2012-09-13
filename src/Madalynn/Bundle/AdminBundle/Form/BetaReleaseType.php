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
use Doctrine\ORM\EntityRepository;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BetaReleaseType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('version', 'entity', array(
                        'label'         => 'backend.beta_release.field.version',
                        'class'         => 'Madalynn\\Bundle\\MainBundle\\Entity\\AndroircVersion',
                        'query_builder' => function(EntityRepository $er) {
                            return $er->createQueryBuilder('e')
                                       ->orderBy('e.code', 'desc');
                        }
                ))
                ->add('file', null, array('label' => 'backend.beta_release.field.file'))
                ->add('downloadable', null, array(
                    'required' => false,
                    'label'    => 'backend.beta_release.field.downloadable'
                ));
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Madalynn\\Bundle\\MainBundle\\Entity\\BetaRelease',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'admin_beta_release';
    }
}
