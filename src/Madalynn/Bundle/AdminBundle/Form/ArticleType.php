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

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('title', null, array('label' => 'article.form.title'))
                ->add('content', 'editor', array('label' => 'article.form.content'))
                ->add('visible', null, array(
                    'required' => false,
                    'label'    => 'article.form.visible'
                ));
    }

    public function getName()
    {
        return 'admin_article';
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Madalynn\\Bundle\\AndroBundle\\Entity\\Article',
        );
    }
}
