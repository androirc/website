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

namespace Madalynn\Bundle\AndroBundle\Controller;

use Madalynn\Bundle\AndroBundle\Entity\CrashReport;

class CrashReportTest extends \PHPUnit_Framework_TestCase
{
    public function testCrashLocation()
    {
        $cr = $this->createCrashReport();

        $this->assertEquals('at com.androirc.AndroIRC$4.run(AndroIRC.java:472)', $cr->getCrashLocation());
    }

    public function testCrashMessage()
    {
        $cr = $this->createCrashReport();

        $this->assertEquals('java.lang.NullPointerException', $cr->getCrashMessage());
    }

    public function testMajorAndroircVersion()
    {
        $cr = $this->createCrashReport();

        $this->assertEquals('3.1', $cr->getMajorAndroircVersion());
    }

    protected function createCrashReport()
    {
        $cr = new CrashReport();

        $cr->setAndroidVersion('2.2.1');
        $cr->setAndroircVersion('3.1 e825cc1- build on 2011/11/26 17:31');
        $cr->setThreadName('main');
        $cr->setCount(0);
        $cr->setResolved(false);
        $cr->setCallstack(<<<EOF
java.lang.NullPointerException
	at com.androirc.AndroIRC$4.run(AndroIRC.java:472)
	at android.os.Handler.handleCallback(Handler.java:587)
	at android.os.Handler.dispatchMessage(Handler.java:92)
	at android.os.Looper.loop(Looper.java:123)
	at android.app.ActivityThread.main(ActivityThread.java:4633)
	at java.lang.reflect.Method.invokeNative(Native Method)
	at java.lang.reflect.Method.invoke(Method.java:521)
	at com.android.internal.os.ZygoteInit.MethodAndArgsCaller.run(ZygoteInit.java:858)
	at com.android.internal.os.ZygoteInit.main(ZygoteInit.java:616)
	at dalvik.system.NativeStart.main(Native Method)
EOF
);

        return $cr;
    }
}
