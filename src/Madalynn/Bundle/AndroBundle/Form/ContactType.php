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

namespace Madalynn\Bundle\AndroBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

use Doctrine\ORM\EntityRepository;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('name', null, array('label' => 'contact.name'))
                ->add('email', 'email', array('label' => 'contact.email'));

        $this->addVersionSection($builder, 'androidVersion', 'android_version', 'apiLevel');
        $this->addVersionSection($builder, 'androircVersion', 'androirc_version', 'code');

        $builder->add('content', 'textarea', array('label' => 'contact.content'));
    }

    protected function addVersionSection(FormBuilder $builder, $name, $slug, $sort)
    {
        $builder->add($name, 'entity', array(
            'class'    => 'Madalynn\\Bundle\\AndroBundle\\Entity\\'.ucfirst($name),
            'label'    => 'contact.'.$slug,
            'required' => false,
            'query_builder' => function(EntityRepository $er) use ($sort) {
                return $er->createQueryBuilder('e')
                           ->orderBy('e.'.$sort, 'desc');
            },
        ));
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Madalynn\\Bundle\\AndroBundle\\Entity\\Contact'
        );
    }

    public function getName()
    {
        return 'contact';
    }
}