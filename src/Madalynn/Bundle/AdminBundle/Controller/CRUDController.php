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

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Doctrine\ORM\QueryBuilder;

use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;

/**
 * CRUD Controller
 *
 * @author Julien Brochet <mewt@androirc.com>
 */
abstract class CRUDController extends Controller
{
    /**
     * The number of entities per page
     *
     * @var integer $maxPerPage
     */
    protected $maxPerPage = 15;

    /**
     * The name of the Entity (e.g. Article)
     *
     * @var string $entityName
     */
    protected $entityName;

    /**
     * The filters
     *
     * @var array $filters
     */
    protected $filters = array();

    /**
     * Execute the list action
     *
     * @param integer $page The page for the pager
     *
     * @return Response
     */
    public function listAction($page)
    {
        $qb = $this->generateFilterQueryBuilder();

        $this->sortQuery($qb);

        $adapter = new DoctrineORMAdapter($qb, true);
        $pager   = new Pagerfanta($adapter);

        $pager->setMaxPerPage($this->maxPerPage);
        $pager->setCurrentPage($page, true, true);

        return $this->render('AdminBundle:' . $this->getEntityName() . ':list.html.twig', array(
            'pager'       => $pager,
            'filter_form' => $this->getFilterForm()->createView()
        ));
    }

    /**
     * Execute the clear action
     *
     * @return Response
     */
    public function clearAction()
    {
        $en = $this->getEntityName();

        $this->get('session')->remove($this->getSessionFilterName());
        $this->get('session')->getFlashBag()->set('success', 'backend.item.clear');

        return $this->redirect($this->generateUrl('admin_' . $this->underscore($en) . '_list'));
    }

    /**
     * Execute the filter action
     *
     * @return Response
     */
    public function filterAction(Request $request)
    {
        $en      = $this->getEntityName();
        $form    = $this->getFilterForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->get('session')->set($this->getSessionFilterName(), $form->getData());
        }

        return $this->redirect($this->generateUrl('admin_' . $this->underscore($en) . '_list'));
    }

    /**
     * Execute the show action
     *
     * @param integer $id The id of the entity
     *
     * @return Response
     */
    public function showAction($id)
    {
        $en     = $this->getEntityName();
        $entity = $this->getRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException(sprintf('Unable to find %s entity.', $en));
        }

        return $this->render('AdminBundle:' . $en . ':show.html.twig', array(
            'entity' => $entity
        ));
    }

    /**
     * Execute the new action
     *
     * @return Response
     */
    public function newAction()
    {
        $entity = $this->getEntity();
        $form   = $this->createForm($this->getForm(), $entity);

        return $this->render('AdminBundle:'. $this->getEntityName() .':new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Create a new entity based on the request
     *
     * @return Response
     */
    public function createAction(Request $request)
    {
        $entity  = $this->getEntity();
        $en      = $this->getEntityName();
        $form    = $this->createForm($this->getForm(), $entity);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $this->prePersist($entity);

            $em->persist($entity);
            $em->flush();

            $this->postPersist($entity);

            $this->get('session')->getFlashBag()->set('success', 'backend.item.create');

            return $this->redirect($this->generateUrl('admin_' . $this->underscore($en) . '_edit', array(
                'id' => $entity->getId()
            )));
        }

        return $this->render('AdminBundle:' . $en . ':new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Edit an entity
     *
     * @param integer $id The id of the entity
     *
     * @return Response
     */
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

    /**
     * Update the entity based on the request parameters
     *
     * @param integer $id The id of the entity
     *
     * @return Response
     */
    public function updateAction(Request $request, $id)
    {
        $en     = $this->getEntityName();
        $entity = $this->getRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException(sprintf('Unable to find %s entity.', $en));
        }

        $editForm = $this->createForm($this->getForm(), $entity);

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $this->preUpdate($entity);

            $em->persist($entity);
            $em->flush();

            $this->postUpdate($entity);

            $this->get('session')->getFlashBag()->set('success', 'backend.item.update');

            return $this->redirect($this->generateUrl('admin_' . $this->underscore($en) . '_edit', array(
                'id' => $id
            )));
        }

        return $this->render('AdminBundle:' . $en . ':edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
     * Remove an entity
     *
     * @param integer $id The id of the entity
     *
     * @return Response
     */
    public function deleteAction($id)
    {
        $en     = $this->getEntityName();
        $entity = $this->getRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException(sprintf('Unable to find %s entity.', $en));
        }

        $em = $this->getDoctrine()->getManager();

        $this->preRemove($entity);

        $em->remove($entity);
        $em->flush();

        $this->postRemove($entity);

        $this->get('session')->getFlashBag()->set('success', 'backend.item.delete');

        return $this->redirect($this->generateUrl('admin_' . $this->underscore($en) . '_list'));
    }

    /**
     * Camelize a string
     *
     * @param string $string The string
     */
    protected function camelize($string)
    {
        return preg_replace_callback('/(^|_|\.)+(.)/', function ($match) { return ('.' === $match[1] ? '_' : '').strtoupper($match[2]); }, $string);
    }

    protected function underscore($string)
    {
        return strtolower(preg_replace(array('/([A-Z]+)([A-Z][a-z])/', '/([a-z\d])([A-Z])/'), array('\\1_\\2', '\\1_\\2'), strtr($string, '_', '.')));
    }

    /**
     * Creates a Query Builder from the data extracts from the session
     *
     * @param QueryBuilder $qb A Query Builder instance
     *
     * @return QueryBuilder The Query Builder with the filter informations
     */
    protected function generateFilterQueryBuilder(QueryBuilder $qb = null)
    {
        if (null == $qb) {
            $qb = $this->getRepository()->createQueryBuilder('e');
        }

        $data = $this->get('session')->get($this->getSessionFilterName());

        if (null !== $data) {
            $i = 0;
            foreach ($data as $key => $value) {
                $qb->andWhere($qb->expr()->like('e.' . $key, '?' . $i));
                $qb->setParameter($i, '%' . $value . '%');
                $i++;
            }
        }

        return $qb;
    }

    /**
     * Returns the entity name from the full class name
     *
     * @return string Entity Name
     */
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
        return $this->getDoctrine()->getRepository($this->getClass());
    }

    /**
     * Create a new instance of the entity
     */
    protected function getEntity()
    {
        $class = $this->getClass();

        return new $class;
    }

    public function render($view, array $parameters = array(), Response $response = null)
    {
        $parameters['entity_name'] = $this->underscore($this->getEntityName());

        return $this->container->get('templating')->renderResponse($view, $parameters, $response);
    }

    /**
     * Creates the filter form
     *
     * @return Form
     */
    protected function getFilterForm()
    {
        $form = $this->createFormBuilder();

        foreach ($this->filters as $filter) {
            $form->add($filter['name'], $filter['type'], array(
                'label'    => $filter['label'],
                'required' => false
            ));
        }

        return $form->getForm();
    }

    protected function getSessionFilterName()
    {
        return 'androirc.admin.filter.' . $this->underscore($this->getEntityName());
    }

    protected function sortQuery(QueryBuilder $qb)
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

    abstract protected function getClass();

    abstract protected function getForm();
}
