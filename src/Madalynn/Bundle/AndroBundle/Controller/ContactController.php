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

namespace Madalynn\Bundle\AndroBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Madalynn\Bundle\AndroBundle\Entity\Contact;
use Madalynn\Bundle\AndroBundle\Form\ContactType;

/**
 * Contact Controller
 *
 * @author Julien Brochet <mewt@androirc.com>
 */
class ContactController extends AbstractController
{
    public function showAction(Request $request)
    {
        $contact = new Contact();
        $form = $this->createForm(new ContactType(), $contact);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $message = \Swift_Message::newInstance();

                $message->setSubject("[AndroIRC] {$contact->name} used the web form to contact us");
                $message->setFrom('contact@androirc.com', 'AndroIRC');
                $message->setTo('contact@androirc.com');
                $message->setReplyTo($contact->email);

                $message->setBody($this->renderView('AndroBundle:Mail:contact.html.twig', array(
                    'name'    => $contact->name,
                    'content' => $contact->content
                )));

                $this->get('mailer')->send($message);
                $this->get('session')->setFlash('notice', 'Your message has been sent!');

                $form->setData(new Contact());
            }
        }

        return $this->render('AndroBundle:Contact:show.html.twig', array(
            'form' => $form->createView()
        ));
    }
}