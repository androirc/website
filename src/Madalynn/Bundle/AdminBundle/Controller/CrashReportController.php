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

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class CrashReportController extends CRUDController
{
    protected $filters = array(
        array(
            'name'  => 'androircVersion',
            'type'  => TextType::class,
            'label' => 'backend.crash_report.field.androirc'
        )
    );

    protected function getForm()
    {
        return null;
    }

    protected function getClass()
    {
        return 'Madalynn\\Bundle\\MainBundle\\Entity\\CrashReport';
    }

    protected function sortQuery(QueryBuilder $qb)
    {
        $qb->orderBy('e.count', 'desc');
    }

    public function deleteAllAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('MainBundle:CrashReport');

        $repo->deleteAll();

        return $this->redirect($this->generateUrl('admin_crash_report_list'));
    }

    public function deleteSelectedAction()
    {
        $em   = $this->getDoctrine()->getManager();
        $list = $this->generateFilterQueryBuilder()->getQuery()->execute();

        foreach ($list as $crash) {
            $em->remove($crash);
        }

        $em->flush();
        $this->get('session')->remove($this->getSessionFilterName());

        return $this->redirect($this->generateUrl('admin_crash_report_list'));
    }

    /**
     * Execute the resolved action
     *
     * @param integer $id The id of the entity
     *
     * @return Response
     */
    public function resolvedAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('MainBundle:CrashReport');

        $crashReport = $repo->find($id);

        if (!$crashReport) {
            throw $this->createNotFoundException('Unable to find CrashReport entity.');
        }

        $crashReport->setResolved(!$crashReport->isResolved());

        $em->persist($crashReport);
        $em->flush();

        return $this->redirect($this->generateUrl('admin_crash_report_list'));
    }

    public function newAction()
    {
        throw new \BadMethodCallException('This action is not supported for this entity.');
    }

    public function createAction(Request $request)
    {
        throw new \BadMethodCallException('This action is not supported for this entity.');
    }

    public function editAction($id)
    {
        throw new \BadMethodCallException('This action is not supported for this entity.');
    }

    public function updateAction(Request $request, $id)
    {
        throw new \BadMethodCallException('This action is not supported for this entity.');
    }
}
