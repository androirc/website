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

namespace Madalynn\Bundle\AdminBundle\Controller;

use Doctrine\ORM\QueryBuilder;

use Madalynn\Bundle\AdminBundle\Form\ArticleType;

class ArticleController extends CRUDController
{
    protected function prePersist($entity)
    {
        $entity->setAuthor($this->getUser());
    }

    protected function sortQuery(QueryBuilder $qb)
    {
        $qb->orderBy('e.created', 'desc');
    }

    public function showAction($id)
    {
        $entity = $this->getRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Article entity.');
        }

        return $this->redirect($this->generateUrl('article_show', array(
            'id'   => $entity->getId(),
            'slug' => $entity->getSlug(),
        )));
    }

    protected function getClass()
    {
        return 'Madalynn\\Bundle\\AndroBundle\\Entity\\Article';
    }

    protected function getForm()
    {
        return new ArticleType();
    }
}
