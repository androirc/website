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

class DonatorType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('name', null, array('label' => 'donator.field.name'))
                ->add('amount', 'money', array(
                    'currency' => 'USD',
                    'label'    => 'donator.field.amount'
                ));
    }

    public function getName()
    {
        return 'admin_donator';
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Madalynn\\Bundle\\AndroBundle\\Entity\\Donator',
        );
    }
}
