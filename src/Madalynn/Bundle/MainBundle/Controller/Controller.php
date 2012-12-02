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

use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;

/**
 * Base controller for factoring usefull methods
 *
 * @author Julien Brochet <mewt@androirc.com>
 */
class Controller extends BaseController
{
    /**
     * Check if the current user has the 'ROLE_ADMIN' role
     *
     * @return boolean true if the user is admin, false otherwise
     */
    public function isAdmin()
    {
        $user = $this->getUser();

        return null !== $user && true === $user->isAdmin();
    }
}
