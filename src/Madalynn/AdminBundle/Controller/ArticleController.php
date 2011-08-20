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

namespace Madalynn\AdminBundle\Controller;

use Madalynn\AndroBundle\Entity\Article;
use Madalynn\AdminBundle\Form\ArticleType;

class ArticleController extends CRUDController
{
    public function prePersist($entity)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $entity->setAuthor($user);
    }

    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('AndroBundle:Article')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Article entity.');
        }

        return $this->redirect($this->generateUrl('article_show', array(
            'id'   => $entity->getId(),
            'slug' => $entity->getSlug(),
        )));
    }

    protected function getEntityName()
    {
        return 'Article';
    }

    protected function getForm()
    {
        return new ArticleType();
    }

    protected function getEntity()
    {
        return new Article();
    }
}
