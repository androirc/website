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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\LanguageType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TipHolidayType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $days = range(1, 31);
        $months = range(1, 12);

        $builder->add('language', LanguageType::class, array(
                    'preferred_choices' => array('en', 'fr'),
                    'label'             => 'backend.tip_holiday.field.language'
                ))
                ->add('day', ChoiceType::class, array(
                    'choices_as_values' => true,
                    'choices' => array_combine($days, $days),
                    'label'   => 'backend.tip_holiday.field.day'
                ))
                ->add('month', ChoiceType::class, array(
                    'choices_as_values' => true,
                    'choices' => array_combine($months, $months),
                    'label'   => 'backend.tip_holiday.field.month'
                ))
                ->add('content', TextareaType::class, array('label' => 'backend.tip_holiday.field.content'));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Madalynn\\Bundle\\MainBundle\\Entity\\TipHoliday',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'admin_tip_holiday';
    }
}
