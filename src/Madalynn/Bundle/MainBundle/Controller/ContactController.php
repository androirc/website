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

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Madalynn\Bundle\MainBundle\Entity\Contact;
use Madalynn\Bundle\MainBundle\Form\ContactType;

/**
 * Contact Controller
 *
 * @author Julien Brochet <mewt@androirc.com>
 */
class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function showAction(Request $request)
    {
        $contact = new Contact();
        $form = $this->createForm(new ContactType(), $contact);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $message = \Swift_Message::newInstance();

                $message->setSubject(sprintf('[AndroIRC] %s used the web form to contact us', $contact->name));
                $message->setFrom('contact@androirc.com', 'AndroIRC');
                $message->setTo('contact@androirc.com');
                $message->setReplyTo($contact->email);

                $message->setBody($this->renderView('MainBundle:Mail:contact.html.twig', array(
                    'name'             => $contact->name,
                    'content'          => $contact->content,
                    'androirc_version' => $contact->androircVersion,
                    'android_version'  => $contact->androidVersion
                )));

                $this->get('mailer')->send($message);
                $this->get('session')->getFlashBag()->set('success', 'contact.flash');

                return $this->redirect($this->generateUrl('contact'));
            }
        }

        return $this->render('MainBundle:Contact:show.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
