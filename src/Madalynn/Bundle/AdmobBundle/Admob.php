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

namespace Madalynn\Bundle\AdmobBundle;

/**
 * AdMob service
 *
 * @author Julien Brochet <mewt@madalynn.eu>
 */
class Admob
{
    protected $publisherId;
    protected $testMode;

    protected $bgcolor;
    protected $textcolor;

    /**
     * Creates the AdMob instance
     *
     * @param string  $publisherId
     * @param Boolean $testMode
     * @param string  $bgcolor
     * @param string  $textcolor
     */
    public function __construct($publisherId, $testMode = true, $bgcolor = 'FFFFFF', $textcolor = '000000')
    {
        $this->publisherId = $publisherId;
        $this->testMode = (Boolean) $testMode;

        $this->bgcolor = $bgcolor;
        $this->textcolor = $textcolor;
    }

    /**
     * Render the advertising
     */
    public function render($id)
    {
        $content = <<<EOF
<script type="text/javascript">
    var admob_vars = {
        bgcolor: '{{ bgcolor }}',
        text: '{{ textcolor }}',
        pubid: '{{ pubid }}',
        test: {{ test_mode }},
        manual_mode: true
    };
</script>
<script type="text/javascript" src="http://mm.admob.com/static/iphone/iadmob.js"></script>
<script type="text/javascript">
    _admob.fetchAd(document.getElementById('{{ id }}'));
</script>
EOF;
          return strtr($content, array(
              '{{ id }}'        => $id,
              '{{ bgcolor }}'   => $this->bgcolor,
              '{{ textcolor }}' => $this->textcolor,
              '{{ test_mode }}' => $this->testMode ? 'true' : 'false',
              '{{ pubid }}'     => $this->publisherId
          ));
    }
}