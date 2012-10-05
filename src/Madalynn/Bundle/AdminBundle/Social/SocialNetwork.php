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

use Madalynn\Bundle\MainBundle\Entity\Article;

/**
 * SocialNetwork
 *
 * @author Julien Brochet <mewt@androirc.com>
 */
interface SocialNetwork
{
    /**
     * Shares an article
     *
     * @param Article $article An article instance
     */
    public function share(Article $article);
}