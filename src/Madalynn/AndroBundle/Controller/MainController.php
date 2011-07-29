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

namespace Madalynn\AndroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Madalynn\AndroBundle\Entity\Contact;
use Madalynn\AndroBundle\Form\ContactType;

class MainController extends Controller
{
    public function homepageAction()
    {
        return $this->render('AndroBundle:Main:homepage.html.twig');
    }

    public function contactAction(Request $request)
    {
        $contact = new Contact();
        $form = $this->createForm(new ContactType(), $contact);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $message = \Swift_Message::newInstance();

                $message->setSubject('[AndroIRC] Someone used the web form to contact us');
                $message->setFrom('contact@androirc.com', 'AndroIRC');
                $message->setTo('contact@androirc.com');
                $message->setReplyTo($contact->email);

                $message->setBody($this->renderView('AndroBundle:Mail:contact.html.twig', array('content' => $contact->content)));

                $this->get('mailer')->send($message);
                $this->get('session')->setFlash('notice', 'Your message has been sent!');
                $form->setData(new Contact());
            }
        }

        return $this->render('AndroBundle:Main:contact.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function eulaAction()
    {
        return $this->render('AndroBundle:Main:eula.html.twig');
    }
}
