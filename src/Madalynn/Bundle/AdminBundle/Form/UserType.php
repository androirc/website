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

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', null, array('label' => 'backend.user.field.username'))
                ->add('email', 'email', array('label' => 'backend.user.field.email'))
                ->add('plainPassword', 'password', array(
                    'label'    => 'backend.user.field.password',
                    'required' => false,
                ))
                ->add('userRoles', 'entity', array(
                    'class'    => 'Madalynn\Bundle\MainBundle\Entity\Role',
                    'multiple' => true,
                    'required' => false,
                    'label'    => 'backend.user.field.roles'
                ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Madalynn\\Bundle\\MainBundle\\Entity\\User',
        ));
    }

    public function getName()
    {
        return 'admin_user';
    }
}
