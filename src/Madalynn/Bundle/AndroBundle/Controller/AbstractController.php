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

namespace Madalynn\Bundle\AndroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Madalynn\Bundle\AndroBundle\Entity\User;

/**
 * Abstract Controller
 *
 * @author Julien Brochet <mewt@androirc.com>
 */
abstract class AbstractController extends Controller
{
    /**
     * Get a user from the Security Context
     *
     * @return mixed
     *
     * @throws \LogicException If SecurityBundle is not available
     */
    public function getUser()
    {
        if (!$this->container->has('security.context')) {
            throw new \LogicException('The SecurityBundle is not installed in your application.');
        }

        $token = $this->container->get('security.context')->getToken();
        $user = null === $token ? null : $token->getUser();

        return $user instanceof User ? $user : null;
    }

    /**
     * Check if the current user has the 'ROLE_ADMIN' role
     *
     * @return boolean True if he is, false otherwise
     */
    public function isAdmin()
    {
        $user = $this->getUser();

        return null !== $user && true === $user->isAdmin();
    }

    /**
     * Renders a different view if the user is coming from the mobile version
     *
     * @param string   $view The view name
     * @param array    $parameters An array of parameters to pass to the view
     * @param Response $response A response instance
     *
     * @return Response A Response instance
     */
    public function renderWithMobile($view, array $parameters = array(), Response $response = null)
    {
        $request = $this->get('request');

        if (true === $request->headers->has('X-AndroIRC-Mobile')) {
            $view = str_replace('.html', '.mobile.html', $view);
        }

        return $this->render($view, $parameters, $response);
    }
}