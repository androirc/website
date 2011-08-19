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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Madalynn\AndroBundle\Entity\Contact;
use Madalynn\AndroBundle\Form\ContactType;
use Madalynn\AndroBundle\Mobile;

class MainController extends MobileController
{
    public function homepageAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('Madalynn\AndroBundle\Entity\Article');

        $articles = $repo->getLastArticles($this->isSuperAdmin());

        return $this->renderWithMobile('AndroBundle:Main:homepage.html.twig', array(
            'articles' => $articles
        ));
    }

    public function contactAction(Request $request)
    {
        $contact = new Contact();
        $form = $this->createForm(new ContactType(), $contact);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                // we need to check if Akismet is ok with the contact form
                $akismet = $this->get('ornicar_akismet');
                $isSpam = $akismet->isSpam(array(
                    'comment_author'  => $contact->name,
                    'comment_content' => $contact->content
                ));

                if (false === $isSpam) {
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
                }

                $form->setData(new Contact());
            }
        }

        return $this->render('AndroBundle:Main:contact.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function eulaAction()
    {
        return $this->renderWithMobile('AndroBundle:Main:eula.html.twig');
    }

    public function screenshotsAction()
    {
        return $this->render('AndroBundle:Main:screenshots.html.twig');
    }

    public function donateAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('Madalynn\AndroBundle\Entity\Donator');

        $donators = $repo->getDonators();

        return $this->renderWithMobile('AndroBundle:Main:donate.html.twig', array(
            'donators' => $donators
        ));
    }

    public function tipAction($lang, $date = null)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $tip = null;

        if (null !== $date) {
            try {
                $date = new \DateTime($date);
            } catch (\Exception $e) {
                throw $this->createNotFoundException('Unable to parse the datetime');
            }

            $repo = $em->getRepository('Madalynn\AndroBundle\Entity\TipHoliday');
            $tip = $repo->findByDate($lang, $date);
        }

        if (null === $tip) {
            $repo = $em->getRepository('Madalynn\AndroBundle\Entity\Tip');
            $tip = $repo->getTip($lang);
        }

        if (null === $tip) {
            return new Reponse('No tips to display');
        }

        return new Response($tip->getContent());
    }

    public function quickstartAction($version, $lang)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('Madalynn\AndroBundle\Entity\QuickStart');

        $quickstart = $repo->findByVersion($version, $lang);

        return $this->render('AndroBundle:Basic:quickstart.html.twig', array(
            'quickstart' => $quickstart
        ));
    }
}
