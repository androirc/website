<?php

/*
 * This file is part of the AndroIRC website.
 *
 * (c) 2010-2011 Julien Brochet <mewt@androirc.com>
 * (c) 2010-2011 Sébastien Brochet <blinkseb@androirc.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MDL\AdminBundle\Form;

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
                    'class'    => 'MDL\AndroBundle\Entity\Role',
                    'multiple' => true,
                    'label'    => 'Roles',
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
            'data_class' => 'MDL\AndroBundle\Entity\User',
        );
    }
}