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

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Madalynn\Bundle\AndroBundle\Entity\Article;

use Faker\Factory as FakerFactory;

/**
 * Article
 *
 * @author Julien Brochet <mewt@androirc.com>
 */
class ArticleFixtures extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param object $manager
     */
    public function load(ObjectManager $em)
    {
        $faker = FakerFactory::create();
        $admin = $this->getReference('user_admin');

        for ($i = 0 ; $i < 30 ; $i++) {
            $article = new Article();

            $article->setTitle($faker->sentence(5));
            $article->setAuthor($admin);
            $article->setContent($faker->text(500));
            $article->setVisible(0 == $i % 2);

            $em->persist($article);
        }

        $em->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 4;
    }
}