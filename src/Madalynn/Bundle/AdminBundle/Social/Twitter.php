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

namespace Madalynn\Bundle\AdminBundle\Social;

use OAuth\TwitterOAuth;
use Madalynn\Bundle\MainBundle\Entity\Article;

class Twitter implements SocialNetwork
{
    /**
     * @var \OAuth\TwitterOAuth
     */
    protected $twitter;

    /**
     * Constructor
     *
     * @param TwitterOAuth $twitter The Twitter library
     */
    public function __construct(TwitterOAuth $twitter)
    {
        $this->twitter = $twitter;
    }

    /**
     * {@inheritdoc}
     */
    public function share(Article $article)
    {
        // $this->twitter->post('statuses/update', array('status' => 'Tweet content')));
    }
}