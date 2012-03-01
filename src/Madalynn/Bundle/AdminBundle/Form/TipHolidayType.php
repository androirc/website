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
use Symfony\Component\Form\Extension\Core\ChoiceList\PaddedChoiceList;

class TipHolidayType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $days = range(1, 31);
        $months = range(1, 12);

        $builder->add('language', 'language', array('preferred_choices' => array('en', 'fr')))
                ->add('day', 'choice', array('choices' => array_combine($days, $days)))
                ->add('month', 'choice', array('choices' => array_combine($months, $months)))
                ->add('content', 'textarea');
    }

    public function getName()
    {
        return 'admin_tip_holiday';
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Madalynn\\Bundle\\AndroBundle\\Entity\\TipHoliday',
        );
    }
}