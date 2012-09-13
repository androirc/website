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

namespace Madalynn\Bundle\MainBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Madalynn\Bundle\MainBundle\Entity\QuickStart;

/**
 * QuickStart Fixtures
 *
 * @author Julien Brochet <mewt@androirc.com>
 */
class QuickStartFixtures extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param object $manager
     */
    public function load(ObjectManager $em)
    {
        $french = new QuickStart();

        $french->setVersionMin($this->getReference('androirc_version_1.0'));
        $french->setLanguage('fr');

        $french->setContent(<<<EOF
<h1>Bienvenue !</h1>
<p>
    Bienvenue sur AndroIRC ! Cette fenêtre s'affiche seulement lors du premier lancement.
    Si IRC n'a plus de secrets pour vous, vous pouvez fermer cette page. Autrement,
    voici une petite introduction.
</p>
<h1>Introduction</h1>
<p>
    AndroIRC vous permet de vous connecter rapidement et simplement à n'importe quel réseau
    IRC. Pour plus d'explication sur le protocole IRC,
    <a href="http://fr.wikipedia.org/wiki/Internet_Relay_Chat">la page wikipedia</a>
    est là ! AndroIRC intègre par défaut cinq serveurs :
</p>
<ul>
    <li>freenode (EN)</li>
    <li>EpiKnet (FR)</li>
    <li>QuakeNet (EN)</li>
    <li>UnderNet (EN)</li>
    <li>KottNet (EN)</li>
</ul>
<h1>Se connecter à un serveur</h1>
<p>
    Pour se connecter, il suffit d'ouvrir le menu (touche <string>menu</string>
    de votre téléphone) et de sélectionner <strong>Connexion</strong>. EpiKnet étant
    le seul serveur francophone par défaut, nous vous conseillons de vous y connecter.
</p>
<h1>Rejoindre un salon</h1>
<p>
    Une fois la connexion réussie, vous devez rejoindre un salon pour pouvoir commencer
    à discuter. Il existe deux manières :
</p>
<ul>
    <li>
        Dans le menu, sélectionnez <strong>Action</strong>, <strong>Rejoindre un salon</strong>
        et indiquez <strong>#dialogues</strong> (seulement pour EpiKnet)
    </li>
    <li>Tapez directement dans la barre <strong>/join #dialogues</strong>.</li>
</ul>
<p>
    Il est bien sûr possible de rejoindre plusieurs salons sur plusieurs serveurs différents !
    Vous pouvez à tout moment voir et naviguer entre vos salons via le menu, rubrique
    <strong>Fenêtres</strong>.
</p>
<strong>Pour plus d'informations</strong> : <a href="http://wiki.androirc.com">wiki</a> [en]
EOF
);
        $em->persist($french);

        $english = new QuickStart();

        $english->setLanguage('en');
        $english->setVersionMin($this->getReference('androirc_version_1.0'));

        $english->setContent(<<<EOF
<h1>Welcome!</h1>
<p>
    Welcome to AndroIRC! This window only appears at first launch.
</p>
<h1>Beginning</h1>
<p>
    AndroIRC allows you to quickly and easily connect to any IRC network.
    For more explanation on the IRC protocol,
    <a href="http://en.wikipedia.org/wiki/Internet_Relay_Chat">the wikipedia page</a>
    is here! AndroIRC includes five servers by default:
</p>
<ul>
    <li>freenode (EN)</li>
    <li>EpiKnet (FR)</li>
    <li>QuakeNet (EN)</li>
    <li>UnderNet (EN)</li>
    <li>KottNet (EN)</li>
</ul>
<h1>Connect to a server</h1>
<p>
    To connect, just open the menu (using the <strong>menu</strong> key of your phone)
    and select <strong>Connect</strong>. You can connect to any IRC network.
    If you do not know which to choose, use freenode.
</p>
<h1>Join a chan</h1>
<p>
    Once the connection is successful, you must join a channel to begin to discuss.
    There are two ways:
</p>
<ul>
    <li>
        In the menu, select <strong>Action</strong>, <strong>Join a chan</strong>
        and indicate #freenode (only for freenode)
    </li>
    <li>
        Write directly into the textbar <strong>/join #freenode</strong>
    </li>
</ul>
<p>
    It is, of course, possible to join several chans on several servers at the same time!
    You can always view and navigate through your chans via the menu,
    item <strong>Windows</strong>.
</p>
EOF
);

        $em->persist($english);
        $em->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 5;
    }
}
