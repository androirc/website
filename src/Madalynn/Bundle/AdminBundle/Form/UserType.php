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

class UserType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('username')
                ->add('email', 'email')
                ->add('plainPassword', 'password', array(
                    'label'    => 'Password',
                    'required' => false
                ))
                ->add('userRoles', 'entity', array(
                    'class'    => 'Madalynn\Bundle\AndroBundle\Entity\Role',
                    'multiple' => true,
                    'label'    => 'Roles',
                    'required' => false
                ));

        $builder->addValidator(new Validator\UserValidator());
    }

    public function getName()
    {
        return 'admin_user';
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Madalynn\Bundle\AndroBundle\Entity\User',
        );
    }
}