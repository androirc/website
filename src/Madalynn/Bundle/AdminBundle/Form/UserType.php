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
use Symfony\Component\Form\FormEvents;
use Madalynn\Bundle\AdminBundle\Form\Listener\UserValidatorListener;

class UserType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('username', null, array('label' => 'user.field.username'))
                ->add('email', 'email', array('label' => 'user.field.email'))
                ->add('plainPassword', 'password', array(
                    'label'    => 'user.field.password',
                    'required' => false,
                ))
                ->add('userRoles', 'entity', array(
                    'class'    => 'Madalynn\Bundle\AndroBundle\Entity\Role',
                    'multiple' => true,
                    'label'    => 'Roles',
                    'required' => false,
                    'label'    => 'user.field.roles'
                ));

        $builder->addEventListener(FormEvents::POST_BIND, array(new UserValidatorListener(), 'onPostBind'));
    }

    public function getName()
    {
        return 'admin_user';
    }

    public function getDefaultOptions()
    {
        return array(
            'data_class' => 'Madalynn\\Bundle\\AndroBundle\\Entity\\User',
        );
    }
}
