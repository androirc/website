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

class AndroircVersionType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('code', null, array('label' => 'androirc_version.field.code'))
                ->add('major', null, array('label' => 'androirc_version.field.major'))
                ->add('minor', null, array('label' => 'androirc_version.field.minor'))
                ->add('revision', null, array('label' => 'androirc_version.field.revision'))
                ->add('state', null, array(
                    'required' => false,
                    'label'    => 'androirc_version.field.state'
                ));
    }

    public function getName()
    {
        return 'admin_androirc_version';
    }

    public function getDefaultOptions()
    {
        return array(
            'data_class' => 'Madalynn\\Bundle\\AndroBundle\\Entity\\AndroircVersion',
        );
    }
}
