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

namespace Madalynn\AndroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MobileController extends Controller
{
    public function render($view, array $parameters = array(), Response $response = null)
    {
        $request = $this->get('request');

        if ($request->getRequestFormat() == 'mobile') {
            $view = str_replace('.html', '.mobile.html', $view);
        }

        return parent::render($view, $parameters, $response);
    }
}