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

use Doctrine\ORM\QueryBuilder;

use Madalynn\AdminBundle\Form\BetaReleaseType;

class CrashReportController extends CRUDController
{
    protected function getForm()
    {
        return null;
    }

    protected function getClass()
    {
        return 'Madalynn\AndroBundle\Entity\CrashReport';
    }

    protected function filterQuery(QueryBuilder $qb)
    {
        $qb->orderBy('e.count', 'desc');
    }

    public function deleteAllAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('AndroBundle:CrashReport');

        $repo->deleteAll();

        return $this->redirect($this->generateUrl('admin_crash_report_list'));
    }

    /**
     * Execute the resolved action
     *
     * @param integer $id The id of the entity
     * @return Response
     */
    public function resolvedAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('AndroBundle:CrashReport');

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

    public function createAction()
    {
        throw new \BadMethodCallException('This action is not supported for this entity.');
    }

    public function editAction($id)
    {
        throw new \BadMethodCallException('This action is not supported for this entity.');
    }

    public function updateAction($id)
    {
        throw new \BadMethodCallException('This action is not supported for this entity.');
    }
}