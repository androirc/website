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

class TipHolidayType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $days = range(1, 31);
        $months = range(1, 12);

        $builder->add('language', 'language', array(
                    'preferred_choices' => array('en', 'fr'),
                    'label'             => 'tip_holiday.field.language'
                ))
                ->add('day', 'choice', array(
                    'choices' => array_combine($days, $days),
                    'label'   => 'tip_holiday.field.day'
                ))
                ->add('month', 'choice', array(
                    'choices' => array_combine($months, $months),
                    'label'   => 'tip_holiday.field.month'
                ))
                ->add('content', 'textarea', array('label' => 'tip_holiday.field.content'));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Madalynn\\Bundle\\MainBundle\\Entity\\TipHoliday',
        ));
    }

    public function getName()
    {
        return 'admin_tip_holiday';
    }
}
