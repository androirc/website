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

use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;

abstract class CRUDController extends Controller
{
    protected $maxPerPage = 15;

    public function indexAction($page)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $en = $this->getEntityName();

        $query = $em->createQuery('SELECT e FROM AndroBundle:' . $en . ' e');
        $adapter = new DoctrineORMAdapter($query, true);

        $pager = new Pagerfanta($adapter);
        $pager->setMaxPerPage($this->maxPerPage);

        try {
            $pager->setCurrentPage($page);
        } catch (\Exception $e) {
            throw $this->createNotFoundException('This page does not exist');
        }

        return $this->render('AdminBundle:' . $en . ':index.html.twig', array(
            'pager' => $pager
        ));
    }

    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $en = $this->getEntityName();

        $entity = $em->getRepository('AndroBundle:' . $en)->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ' . $en . ' entity.');
        }

        return $this->render('AdminBundle:' . $en . ':show.html.twig', array(
            'entity'      => $entity,
        ));
    }

    public function newAction()
    {
        $entity = $this->getEntity();
        $form   = $this->createForm($this->getForm(), $entity);

        return $this->render('AdminBundle:'. $this->getEntityName() .':new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    public function createAction()
    {
        $entity  = $this->getEntity();
        $en      = $this->getEntityName();
        $request = $this->getRequest();
        $form    = $this->createForm($this->getForm(), $entity);

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();

            $this->prePersist($entity);

            $em->persist($entity);
            $em->flush();

            $this->postPersist($entity);

            return $this->redirect($this->generateUrl('admin_' . strtolower($en) . '_edit', array(
                'id' => $entity->getId()
            )));
        }

        return $this->render('AdminBundle:' . $en . ':new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $en = $this->getEntityName();

        $entity = $em->getRepository('AndroBundle:' . $en)->find($id);

        if (!$entity) {
            throw $this->createNotFoundException(sprintf('Unable to find %s entity.', $en));
        }

        $editForm = $this->createForm($this->getForm(), $entity);

        return $this->render('AdminBundle:' . $en . ':edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }

    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $en = $this->getEntityName();

        $entity = $em->getRepository('AndroBundle:' . $en)->find($id);

        if (!$entity) {
            throw $this->createNotFoundException(sprintf('Unable to find %s entity.', $en));
        }

        $editForm = $this->createForm($this->getForm(), $entity);
        $request  = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $this->preUpdate($entity);

            $em->persist($entity);
            $em->flush();

            $this->postUpdate($entity);

            $this->get('session')->setFlash('notice', 'The item was updated successfully.');

            return $this->redirect($this->generateUrl('admin_' . strtolower($en) . '_edit', array(
                'id' => $id
            )));
        }

        return $this->render('AdminBundle:' . $en . ':edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }

    public function deleteAction($id)
    {
        $request = $this->getRequest();
        $em      = $this->getDoctrine()->getEntityManager();
        $en      = $this->getEntityName();
        $entity  = $em->getRepository('AndroBundle:' . $en)->find($id);

        if (!$entity) {
            throw $this->createNotFoundException(sprintf('Unable to find %s entity.', $en));
        }

        $this->preRemove($entity);

        $em->remove($entity);
        $em->flush();

        $this->postRemove($entity);

        $this->get('session')->setFlash('notice', 'The item was deleted successfully.');

        return $this->redirect($this->generateUrl('admin_' . strtolower($en)));
    }

    protected function preUpdate($entity)
    {
    }

    protected function postUpdate($entity)
    {
    }

    protected function prePersist($entity)
    {
    }

    protected function postPersist($entity)
    {
    }

    protected function preRemove($entity)
    {
    }

    protected function postRemove($entity)
    {
    }

    abstract protected function getEntity();

    abstract protected function getEntityName();

    abstract protected function getForm();
}