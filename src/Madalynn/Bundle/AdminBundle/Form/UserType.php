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
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', null, array('label' => 'backend.user.field.username'))
                ->add('email', EmailType::class, array('label' => 'backend.user.field.email'))
                ->add('plainPassword', PasswordType::class, array(
                    'label'    => 'backend.user.field.password',
                    'required' => false,
                ))
                ->add('userRoles', EntityType::class, array(
                    'class'    => 'Madalynn\Bundle\MainBundle\Entity\Role',
                    'multiple' => true,
                    'required' => false,
                    'label'    => 'backend.user.field.roles'
                ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Madalynn\\Bundle\\MainBundle\\Entity\\User',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'admin_user';
    }
}
