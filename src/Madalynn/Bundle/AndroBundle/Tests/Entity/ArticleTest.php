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
    /**
     * @dataProvider dataSlug
     */
    public function testSlug($title, $slug)
    {
        $article = new Article();
        $article->setTitle($title);

        $this->assertEquals($slug, $article->getSlug());
    }

    public function testUpdateSlug()
    {
        $article = new Article();

        $article->setTitle('AndroIRC 3.3');
        $this->assertEquals('androirc-3-3', $article->getSlug());

        $article->setTitle('Hello world');
        $this->assertEquals('hello-world', $article->getSlug());
    }

    public function dataSlug()
    {
        return array(
            array('AndroIRC 3.3 now available on the Market!', 'androirc-3-3-now-available-on-the-market'),
            array('Simple title', 'simple-title'),
            array('FOOBAR', 'foobar'),
        );
    }
}
