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

namespace Madalynn\Bundle\AdminBundle\Type;

use Symfony\Component\Form\AbstractType;

/**
 * Editor Type
 *
 * @author Julien Brochet <mewt@androirc.com>
 */
class EditorType extends AbstractType
{
    public function getName()
    {
        return 'editor';
    }

    /**
     * @param array $options
     *
     * @return string
     */
    public function getParent(array $options)
    {
        return 'textarea';
    }

    /**
     * @param array $options
     *
     * @return array
     */
    public function getDefaultOptions()
    {
        return array(
            'required' => false,
            'attr'     => array('class' => 'editor')
        );
    }
}