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

namespace Madalynn\Bundle\MainBundle\Tests\Entity;

use Madalynn\Bundle\MainBundle\Entity\CrashReport;
use Madalynn\Bundle\MainBundle\Entity\Logcat;

class CrashReportTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider dataCrashReport
     *
     * @covers CrashReport::getCrashLocation
     */
    public function testCrashLocation(CrashReport $cr)
    {
        $this->assertEquals('at com.androirc.AndroIRC$4.run(AndroIRC.java:472)', $cr->getCrashLocation());
    }

    /**
     * @dataProvider dataCrashReport
     *
     * @covers CrashReport::getCrashMessage
     */
    public function testCrashMessage(CrashReport $cr)
    {
        $this->assertEquals('java.lang.NullPointerException', $cr->getCrashMessage());
    }

    /**
     * @dataProvider dataCrashReport
     *
     * @covers CrashReport::getThreadName
     */
    public function testThreadName(CrashReport $cr)
    {
        $this->assertEquals('main', $cr->getThreadName());
    }

    /**
     * @dataProvider dataCrashReport
     *
     * @covers CrashReport::getCount
     * @covers CrashReport::incCount
     */
    public function testCount(CrashReport $cr)
    {
        $this->assertEquals(1, $cr->getCount());

        $cr->incCount();
        $this->assertEquals(2, $cr->getCount());

        $cr->incCount(10);
        $this->assertEquals(12, $cr->getCount());
    }

    /**
     * @dataProvider dataCrashReport
     *
     * @covers CrashReport::setResolved
     * @covers CrashReport::isResolved
     */
    public function testResolved(CrashReport $cr)
    {
        $cr->setResolved(false);
        $this->assertFalse($cr->isResolved());

        $cr->setResolved(true);
        $this->assertTrue($cr->isResolved());
    }

    /**
     * @dataProvider dataCrashReport
     *
     * @covers CrashReport::getMajorAndroircVersion
     */
    public function testMajorAndroircVersion(CrashReport $cr)
    {
        $this->assertEquals('3.1', $cr->getMajorAndroircVersion());
    }

    /**
     * @dataProvider dataCrashReport
     *
     * @covers CrashReport::getAndroidVersion
     */
    public function testAndroidVersion(CrashReport $cr)
    {
        $this->assertEquals('2.2.1', $cr->getAndroidVersion());
    }

    /**
     * @dataProvider dataCrashReport
     *
     * @covers CrashReport::getAndroircVersion
     */
    public function testAndroircVersion(CrashReport $cr)
    {
        $this->assertEquals('3.1 e825cc1- build on 2011/11/26 17:31', $cr->getAndroircVersion());
    }

    /**
     * @dataProvider dataCrashReport
     *
     * @covers CrashReport::addLogcat
     * @covers CrashReport::removeLogcat
     * @covers CrashReport::getLogcats
     */
    public function testLogcats(CrashReport $cr)
    {
        $logcat = new Logcat();
        $logcat->setLogcat("I'm a logcat");

        $this->assertCount(0, $cr->getLogcats());
        $cr->addLogcat($logcat);

        $this->assertCount(1, $cr->getLogcats());
        $this->assertSame($cr, $cr->getLogcats()->get(0)->getCrashReport());

        $cr->removeLogcat($logcat);
        $this->assertCount(0, $cr->getLogcats());
    }

    public function dataCrashReport()
    {
        $cr = new CrashReport();

        $cr->setAndroidVersion('2.2.1');
        $cr->setAndroircVersion('3.1 e825cc1- build on 2011/11/26 17:31');
        $cr->setThreadName('main');
        $cr->setCount(1);
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

        return array(array($cr));
    }
}
