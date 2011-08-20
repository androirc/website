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

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Madalynn\AndroBundle\Entity\Article;
use Madalynn\AdminBundle\Form\ArticleType;

class ArticleController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $query = $em->createQuery('SELECT a FROM Madalynn\AndroBundle\Entity\Article a');
        $entities = $query->getResult();

        return $this->render('AdminBundle:Article:index.html.twig', array(
            'entities' => $entities
        ));
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
            'slug' => $entity->getSlug()
        )));
    }

    public function newAction()
    {
        $entity = new Article();
        $form   = $this->createForm(new ArticleType(), $entity);

        return $this->render('AdminBundle:Article:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    public function createAction()
    {
        $entity  = new Article();
        $request = $this->getRequest();
        $form    = $this->createForm(new ArticleType(), $entity);

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();

            // we inject the current user
            $user = $this->get('security.context')->getToken()->getUser();
            $entity->setAuthor($user);

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_article_show', array('id' => $entity->getId())));
        }

        return $this->render('AdminBundle:Article:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AndroBundle:Article')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Article entity.');
        }

        $editForm = $this->createForm(new ArticleType(), $entity);

        return $this->render('AdminBundle:Article:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }

    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AndroBundle:Article')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Article entity.');
        }

        $editForm = $this->createForm(new ArticleType(), $entity);
        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_article_edit', array('id' => $id)));
        }

        return $this->render('AdminBundle:Article:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }

    public function deleteAction($id)
    {
        $request = $this->getRequest();
        
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('AndroBundle:Article')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Article entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('admin_article'));
    }
}
