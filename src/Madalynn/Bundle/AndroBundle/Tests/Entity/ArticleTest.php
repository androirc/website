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

namespace Madalynn\Bundle\AndroBundle\Tests\Entity;

use Madalynn\Bundle\AndroBundle\Entity\Article;

class ArticleTest extends \PHPUnit_Framework_TestCase
{
    public function testArticleSlug()
    {
        $article = new Article();
        $article->setTitle('Quaerat fuga quaerat vel et.');

        $this->assertEquals('quaerat-fuga-quaerat-vel-et', $article->getSlug());

        $article->setTitle('Another title');

        $this->assertEquals('quaerat-fuga-quaerat-vel-et', $article->getSlug());
    }
}
