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
use Symfony\Component\HttpFoundation\Response;

use Doctrine\ORM\QueryBuilder;

use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;

abstract class CRUDController extends Controller
{
    protected $maxPerPage = 15;
    protected $repositoryName;
    protected $entityName;

    public function listAction($page)
    {
        // Filter Doctrine Query
        $qb = $this->getRepository()->createQueryBuilder('e');
        $this->filterQuery($qb);

        $adapter = new DoctrineORMAdapter($qb->getQuery(), true);

        $pager = new Pagerfanta($adapter);
        $pager->setMaxPerPage($this->maxPerPage);

        try {
            $pager->setCurrentPage($page);
        } catch (\Exception $e) {
            throw $this->createNotFoundException('This page does not exist');
        }

        return $this->render('AdminBundle:' . $this->getEntityName() . ':list.html.twig', array(
            'pager' => $pager
        ));
    }

    public function showAction($id)
    {
        $en     = $this->getEntityName();
        $entity = $this->getRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException(sprintf('Unable to find %s entity.', $en));
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

            return $this->redirect($this->generateUrl('admin_' . $this->urlize($en) . '_edit', array(
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
        $en     = $this->getEntityName();
        $entity = $this->getRepository()->find($id);

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
        $en     = $this->getEntityName();
        $entity = $this->getRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException(sprintf('Unable to find %s entity.', $en));
        }

        $editForm = $this->createForm($this->getForm(), $entity);
        $request  = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();

            $this->preUpdate($entity);

            $em->persist($entity);
            $em->flush();

            $this->postUpdate($entity);

            $this->get('session')->setFlash('notice', 'The item was updated successfully.');

            return $this->redirect($this->generateUrl('admin_' . $this->urlize($en) . '_edit', array(
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
        $en      = $this->getEntityName();
        $entity  = $this->getRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException(sprintf('Unable to find %s entity.', $en));
        }

        $em = $this->getDoctrine()->getEntityManager();

        $this->preRemove($entity);

        $em->remove($entity);
        $em->flush();

        $this->postRemove($entity);

        $this->get('session')->setFlash('notice', 'The item was deleted successfully.');

        return $this->redirect($this->generateUrl('admin_' . $this->urlize($en) . '_list'));
    }

    protected function filterQuery(QueryBuilder $qb)
    {
        $qb->orderBy('e.id', 'desc');
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

    protected function urlize($word, $sep = '_')
    {
        return strtolower(preg_replace('/[^a-z0-9_]/i', $sep.'$1', $word));
    }

    protected function getEntityName()
    {
        if ($this->entityName) {
            return $this->entityName;
        }

        $class = $this->getClass();

        return $this->entityName = substr($class, strrpos($class, '\\') + 1);
    }

    protected function getRepository()
    {
        if (!$this->repositoryName) {
            $bundles = $this->get('kernel')->getBundles();
            $class   = $this->getClass();
            $name    = '';

            foreach ($bundles as $bundle) {
                if (0 === strpos($class, $bundle->getNamespace())) {
                    $name = $bundle->getName();
                    break;
                }
            }

            if (!$name) {
                throw new \Exception(sprintf('Unable to find the bundle for the %s entity.', $class));
            }

            $this->repositoryName = $name . ':' . $this->getEntityName();
        }

        return $this->getDoctrine()->getRepository($this->repositoryName);
    }

    protected function getEntity()
    {
        $reflexion = new \ReflectionClass($this->getClass());

        return $reflexion->newInstance();
    }

    public function render($view, array $parameters = array(), Response $response = null)
    {
        $parameters['entity_name'] = $this->urlize($this->getEntityName());

        return $this->container->get('templating')->renderResponse($view, $parameters, $response);
    }

    abstract protected function getClass();

    abstract protected function getForm();
}