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

namespace Madalynn\Bundle\AndroBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;

use Madalynn\Bundle\AndroBundle\Entity\Tip;

/**
 * Tip Fixtures
 *
 * @author Julien Brochet <mewt@androirc.com>
 */
class TipFixtures implements FixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param object $manager
     */
    public function load($em)
    {
        $tips = array(
            array(
                'lang'    => 'fr',
                'content' => 'Vous pouvez faire un don pour supporter AndroIRC via le lien suivant : www.androirc.com/donate'
            ),
            array(
                'lang'    => 'fr',
                'content' => 'Vous pouvez suivre rapidement AndroIRC grâce à son Twitter ! twitter.com/androirc'
            ),
            array(
                'lang'    => 'fr',
                'content' => 'Vous pouvez vous connecter automatiquement  à un serveur au lancement de AndroIRC'
            ),
            array(
                'lang'    => 'fr',
                'content' => 'Vous pouvez afficher l\'heure devant chaque message. (Activable dans les préférences, rubrique \'Divers\')'
            ),
            array(
                'lang'    => 'fr',
                'content' => 'Vous pouvez spécifier un pseudonyme différent pour chaque serveur'
            ),
            array(
                'lang'    => 'fr',
                'content' => 'Vous pouvez vous identifier automatiquement à la connexion d\'un serveur via NickServ ou en SASL'
            ),
            array(
                'lang'    => 'fr',
                'content' => 'En laissant appuyé sur un message, celui-ci est directement copié dans le presse-papier'
            ),
            array(
                'lang'    => 'fr',
                'content' => 'Vous pouvez naviguer facilement entre vos salons en appuyant légèrement sur l\'écran'
            ),
            array(
                'lang'    => 'fr',
                'content' => 'Une double pression sur l\'écran affiche la liste des utilisateurs du salon en cours'
            ),
            array(
                'lang'    => 'fr',
                'content' => 'Vous pouvez vous tenir au courant de l\'évolution de AndroIRC via le site officiel'
            ),
            array(
                'lang'    => 'fr',
                'content' => 'Vous pouvez colorer votre texte facilement via l\'icône présent à droite de la zone de saisie'
            ),
            array(
                'lang'    => 'fr',
                'content' => 'Il est possible de vous identifier à la connexion grâce au protocole SASL (PLAIN ou BLOWFISH)'
            ),
            array(
                'lang'    => 'fr',
                'content' => 'Il est possible d\'enregistrer l\'ensemble des conversations automatiquement sur la carte SD'
            ),
            array(
                'lang'    => 'fr',
                'content' => 'Vous pouvez augmenter la taille de la police facilement dans les préférences'
            ),
            array(
                'lang'    => 'fr',
                'content' => 'Il est possible d\'ajouter un raccourci sur votre bureau pour vous connecter directement à un serveur en particulier'
            ),
            array(
                'lang'    => 'fr',
                'content' => 'Vous pouvez exécuter vos propres commandes à la connexion d\'un serveur'
            ),
            array(
                'lang'    => 'fr',
                'content' => 'Vous pouvez changer de thème pour passer à un plus sombre'
            ),
            array(
                'lang'    => 'fr',
                'content' => 'Un soucis ? Une question ? Regardez le wiki officiel : wiki.androirc.com'
            ),
            array(
                'lang'    => 'fr',
                'content' => 'Devenez fan de la page Facebook ! facebook.com/androirc'
            ),
            array(
                'lang'    => 'fr',
                'content' => 'Vous aimez AndroIRC ? Alors ajoutez un commentaire sur l\'Android Market, ça fait toujours plaisir ;)'
            ),
            array(
                'lang'    => 'fr',
                'content' => 'Vous pouvez supporter AndroIRC en téléchargeant l\'application "AndroIRC premium" qui désactive la publicité !'
            ),
            array(
                'lang'    => 'fr',
                'content' => 'Vous pouvez effectuer une auto-complétion des utilisateurs via la touche <i>Recherche</i> de votre téléphone'
            ),
            array(
                'lang'    => 'fr',
                'content' => 'AndroIRC supporte maintenant le protocole <b>FiSH</b>. Plus d\'informations sur le wiki'
            ),
            array(
                'lang'    => 'en',
                'content' => 'AndroIRC is now on Twitter ! twitter.com/androirc'
            ),
            array(
                'lang'    => 'en',
                'content' => 'You can make a donation to support AndroIRC. See www.androirc.com/donate'
            ),
            array(
                'lang'    => 'en',
                'content' => 'You can auto-connect to your servers on startup'
            ),
            array(
                'lang'    => 'en',
                'content' => 'You can show a timestamp before each message'
            ),
            array(
                'lang'    => 'en',
                'content' => 'You can choose a different nickname per server'
            ),
            array(
                'lang'    => 'en',
                'content' => 'You can auto-ident on server using NickServ'
            ),
            array(
                'lang'    => 'en',
                'content' => 'When longpressing on a message, the text is automatically copied on the clipboard'
            ),
            array(
                'lang'    => 'en',
                'content' => 'You can easily navigate betwwen your channels by single tapping on your touch-screen'
            ),
            array(
                'lang'    => 'en',
                'content' => 'You can be kept updated by visiting our official website'
            ),
            array(
                'lang'    => 'en',
                'content' => 'You can choose a different theme for the app : <b>classic</b> or <b>black</b>'
            ),
            array(
                'lang'    => 'en',
                'content' => 'Become a fan of the Facebook page ! facebook.com/androirc'
            ),
            array(
                'lang'    => 'en',
                'content' => 'Verizon blocks IRC over 3G. You won\'t be able to use AndroIRC over 3G, you will need to use WiFi'
            ),
            array(
                'lang'    => 'en',
                'content' => 'You can help us translating AndroIRC on translation.androirc.com'
            ),
            array(
                'lang'    => 'en',
                'content' => 'You can support AndroIRC by downloading the application "AndroIRC premium" which disable the advertising!'
            ),
            array(
                'lang'    => 'en',
                'content' => 'You can perform auto-complete via the <i>research</i> button on your phone'
            ),
            array(
                'lang'    => 'en',
                'content' => 'AndroIRC now supports the <b>FiSH</b> protocol. More information on the wiki'
            )
        );

        foreach ($tips as $tip) {
            $tmp = new Tip();

            $tmp->setContent($tip['content']);
            $tmp->setLanguage($tip['lang']);

            $em->persist($tmp);
        }

        $em->flush();
    }
}