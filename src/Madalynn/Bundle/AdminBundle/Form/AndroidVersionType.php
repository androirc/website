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

class AndroidVersionType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('apiLevel', null, array('label' => 'android_version.field.api_level'))
                ->add('major', null, array('label' => 'android_version.field.major'))
                ->add('minor', null, array('label' => 'android_version.field.minor'))
                ->add('revision', null, array('label' => 'android_version.field.revision'));
    }

    public function getName()
    {
        return 'admin_android_version';
    }

    public function getDefaultOptions()
    {
        return array(
            'data_class' => 'Madalynn\\Bundle\\AndroBundle\\Entity\\AndroidVersion',
        );
    }
}
