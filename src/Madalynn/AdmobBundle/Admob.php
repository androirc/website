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

namespace Madalynn\AdmobBundle;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session;

/**
 * AdMob service
 *
 * @author Julien Brochet <mewt@madalynn.eu>
 */
class Admob
{
    protected $session;
    protected $publisherId;
    protected $analyticsId;
    protected $sessionId;

    protected $adRequest;
    protected $analyticsRequest;
    protected $testMode;
    protected $pixelSent;
    protected $options;

    /**
     * Creates the AdMob instance
     *
     * @param Session $session
     * @param string  $publisherId
     * @param string  $analyticsId
     * @param Boolean $adRequest
     * @param Boolean $analyticsRequest
     * @param Boolean $testMode
     * @param array   $options
     */
    public function __construct(Session $session, $publisherId, $analyticsId, $adRequest = true, $analyticsRequest = false, $testMode = true, array $options = array())
    {
        $this->session = $session;
        $this->publisherId = $publisherId;
        $this->analyticsId = $analyticsId;

        $this->adRequest = (Boolean) $adRequest;
        $this->analyticsRequest = (Boolean) $analyticsRequest;
        $this->testMode = (Boolean) $testMode;
        $this->options = $options;

        $this->sessionId = false;
    }

    /**
     * Render the advertising
     *
     * @param Request $request The request
     * @return string The <img /> tag
     */
    public function render(Request $request)
    {
        if (false === function_exists('curl_init')) {
            throw new \Exception('AdmobBundle needs the curl extension.');
        }

        $this->pixelSent = false;
        $analyticsMode = false;
        $adMode = false;

        if ($this->adRequest && $this->publisherId) {
            $adMode = true;
        }

        if ($this->analyticsRequest && $this->analyticsId && !$this->pixelSent) {
            $analyticsMode = true;
        }

        $rt = $adMode ? ($analyticsMode ? 2 : 0) : ($analyticsMode ? 1 : -1);

        if ($rt == -1) {
            return '';
        }

        list($usec, $sec) = explode(' ', microtime());
        $params = array('rt=' . $rt,
                  'z=' . ($sec + $usec),
                  'u=' . urlencode($request->server->get('HTTP_USER_AGENT')),
                  'i=' . urlencode($request->getClientIp()),
                  'p=' . urlencode($request->getUri()),
                  'v=' . urlencode('20081105-PHPCURL-acda0040bcdea222'));

        if (false === $this->sessionId) {
            $this->sessionId = $this->session->getId();
        }

        if ($this->sessionId) {
            $params[] = 't=' . md5($this->sessionId);
        }

        if (true === $adMode) {
            $params[] = 's=' . $this->publisherId;
        }

        if (true === $analyticsMode) {
            $params[] = 'a=' . $this->analyticsId;
        }

        if (true === $request->cookies->has('admobuu')) {
            $params[] = 'o=' . $request->cookies->get('admobuu');
        }

        if (true === $this->testMode) {
            $params[] = 'm=test';
        }

        if (false === empty($this->options)) {
            foreach ($this->options as $key => $value) {
                $params[] = urlencode($key) . '=' . urlencode($value);
            }
        }

        $ignore = array(
            'HTTP_PRAGMA', 'HTTP_CACHE_CONTROL',
            'HTTP_CONNECTION', 'HTTP_USER_AGENT',
            'HTTP_COOKIE'
        );

        // Ignore somes HTTP_ header
        $path = $request->server->all();
        foreach ($path as $key => $value) {
            if (substr($key, 0, 4) == 'HTTP' && false === in_array($key, $ignore)) {
                $params[] = urlencode('h[' . $key . ']') . '=' . urlencode($value);
            }
        }

        $post = implode('&', $params);
        $curl = curl_init();
        $curlTimeout = 1;

        // FIXME: Use Buzz instead of curl?
        curl_setopt($curl, CURLOPT_URL, 'http://r.admob.com/ad_source.php');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, $curlTimeout);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $curlTimeout);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded', 'Connection: Close'));
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);

        list($usecStart, $secStart) = explode(' ', microtime());

        // We send the request to AdMob
        $contents = curl_exec($curl);

        list($usecEnd, $secEnd) = explode(' ', microtime());

        // We close the curl socket
        curl_close($curl);

        if (true === is_bool($contents)) {
            $contents = '';
        }

        if (false === $this->pixelSent) {
            $this->pixelSent = true;

            $contents .= '<img src=' . $request->getScheme() . '://p.admob.com/e0?'
                  . 'rt=' . $rt
                  . '&amp;z=' . ($sec + $usec)
                  . '&amp;a=' . (true === $analyticsMode ? $this->analyticsId : '')
                  . '&amp;s=' . (true === $adMode ? $this->publisherId : '')
                  . '&amp;o=' . (true ===  $request->cookies->has('admobuu') ? $request->cookies->get('admobuu') : '')
                  . '&amp;lt=' . ($secEnd + $usecEnd - $secStart - $usecStart)
                  . '&amp;to=' . $curlTimeout
                  . '" alt="" width="1" height="1"/>';
        }

        return $contents;
    }

    public function hasPixelSent()
    {
        return $this->pixelSent;
    }
}