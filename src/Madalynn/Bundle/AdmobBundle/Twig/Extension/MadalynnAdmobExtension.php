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

namespace Madalynn\Bundle\AdmobBundle\Twig\Extension;

use Madalynn\Bundle\AdmobBundle\Admob;

/**
 * AdMob extension for Twig
 *
 * @author Julien Brochet <mewt@madalynn.eu>
 */
class MadalynnAdmobExtension extends \Twig_Extension
{
    protected $admob;

    /**
     * @param Admob $admob
     */
    public function __construct(Admob $admob)
    {
        $this->admob = $admob;
    }

    public function getFunctions()
    {
        return array(
            'madalynn_admob' => new \Twig_Function_Method($this, 'render', array('is_safe' => array('html')))
        );
    }

    public function render($id)
    {
        return $this->admob->render($id);
    }

    public function getName()
    {
        return 'madalynn_admob';
    }
}