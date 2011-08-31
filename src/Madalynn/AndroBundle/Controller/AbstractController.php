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

use Madalynn\AndroBundle\Entity\User;

abstract class AbstractController extends Controller
{
    public function getUser()
    {
        if (!$this->container->has('security.context')) {
            throw new \LogicException('The SecurityBundle is not installed in your application.');
        }

        $token = $this->container->get('security.context')->getToken();
        $user = null === $token ? null : $token->getUser();

        return $user instanceof User ? $user : null;
    }

    public function isAdmin()
    {
        $user = $this->getUser();

        return null !== $user && true === $user->isAdmin();
    }

    public function renderWithMobile($view, array $parameters = array(), Response $response = null)
    {
        $request = $this->get('request');

        if (true === $request->headers->has('X-AndroIRC-Mobile')) {
            $view = str_replace('.html', '.mobile.html', $view);
        }

        return $this->render($view, $parameters, $response);
    }
}