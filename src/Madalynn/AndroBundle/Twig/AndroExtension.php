<?php

/*
 * This file is part of the AndroIRC website.
 *
 * (c) 2010-2011 Julien Brochet <mewt@androirc.com>
 * (c) 2010-2011 Sébastien Brochet <blinkseb@androirc.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Madalynn\AndroBundle\Twig;

use Symfony\Component\Routing\RouterInterface;

class AndroExtension extends \Twig_Extension
{
    protected $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function getFilters()
    {
        return array(
            'sha1' => new \Twig_Filter_Method($this, 'sha1'),
            'md5'  => new \Twig_Filter_Method($this, 'md5')
        );
    }

    public function sha1($text)
    {
        return sha1($text);
    }

    public function md5($text)
    {
        return md5($text);
    }

    public function getName()
    {
        return 'andro';
    }
}