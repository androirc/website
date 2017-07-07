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

use Madalynn\Bundle\AdminBundle\Form\BetaReleaseType;

use Doctrine\ORM\QueryBuilder;

class BetaReleaseController extends CRUDController
{
    protected function getForm()
    {
        return BetaReleaseType::class;
    }

    protected function getClass()
    {
        return 'Madalynn\\Bundle\\MainBundle\\Entity\\BetaRelease';
    }

    protected function sortQuery(QueryBuilder $qb)
    {
        $qb->leftjoin('e.version', 'v')
           ->orderBy('v.code', 'desc');
    }

    public function showAction($id)
    {
        $entity = $this->getRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find the BetaRelease entity.');
        }

        return $this->render('AdminBundle:BetaRelease:show.html.twig', array(
            'entity'      => $entity,
            'repartition' => $this->getDoctrine()->getRepository('MainBundle:BetaDownload')->getDownloadsRepartition($entity)
        ));
    }
}
