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

use Doctrine\ORM\EntityRepository;

class ChangeLogType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('version', 'entity', array(
                    'label' => 'change_log.field.version',
                    'class' => 'Madalynn\\Bundle\\AndroBundle\\Entity\\AndroircVersion',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('v')
                                  ->orderBy('v.code', 'desc');
                    }
                ))
                ->add('file', null, array('label' => 'change_log.field.file'));

        $builder->addValidator(new Validator\FileValidator());
    }

    public function getName()
    {
        return 'admin_change_log';
    }

    public function getDefaultOptions()
    {
        return array(
            'data_class' => 'Madalynn\\Bundle\\AndroBundle\\Entity\\ChangeLog',
        );
    }
}
