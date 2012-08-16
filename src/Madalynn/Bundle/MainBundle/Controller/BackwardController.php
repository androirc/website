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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Controller for backward compatibility
 */
class BackwardController extends Controller
{
    /**
     * @Route("/article/{id}/{slug}")
     */
    public function articleShowAction($id, $slug)
    {
        return $this->redirect($this->generateUrl('blog_show', array(
            'id'   => $id,
            'slug' => $slug,
        )));
    }

    /**
     * @Route("/archives/{page}")
     */
    public function archivesAction($page)
    {
        return $this->redirect($this->generateUrl('blog'));
    }

    /**
     * @Route("/eula")
     */
    public function eulaAction()
    {
        return $this->redirect($this->generateUrl('terms'));
    }

    /**
     * @Route("/screenshots")
     */
    public function screenshotsAction()
    {
        return $this->redirect($this->generateUrl('homepage'));
    }

    /**
     * @Route("/donate")
     */
    public function donateAction()
    {
        return $this->redirect($this->generateUrl('homepage'));
    }
}