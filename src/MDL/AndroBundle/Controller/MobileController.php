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

namespace MDL\AndroBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

class MobileController extends AbstractController
{
    public function renderWithMobile($view, array $parameters = array(), Response $response = null)
    {
        $request = $this->get('request');

        if (true === $request->headers->has('X-AndroIRC-Mobile')) {
            $view = str_replace('.html', '.mobile.html', $view);
        }

        return $this->render($view, $parameters, $response);
    }
}