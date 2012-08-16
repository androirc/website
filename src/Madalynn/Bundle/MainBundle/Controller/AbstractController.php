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

namespace Madalynn\Bundle\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Abstract Controller
 *
 * @author Julien Brochet <mewt@androirc.com>
 */
abstract class AbstractController extends Controller
{
    /**
     * Check if the current user has the 'ROLE_ADMIN' role
     *
     * @return boolean true if he is, false otherwise
     */
    public function isAdmin()
    {
        $user = $this->getUser();

        return null !== $user && true === $user->isAdmin();
    }

    /**
     * Renders a different view if the user is coming from the mobile version
     *
     * @param string   $view       The view name
     * @param array    $parameters An array of parameters to pass to the view
     * @param Response $response   A response instance
     *
     * @return Response A Response instance
     */
    public function renderWithMobile($view, array $parameters = array(), Response $response = null)
    {
        if (true === $this->get('request')->headers->has('X-AndroIRC-Mobile')) {
            $view = str_replace('.html', '.mobile.html', $view);
        }

        return $this->render($view, $parameters, $response);
    }
}
