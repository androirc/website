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

use Madalynn\Bundle\MainBundle\Entity\CrashReport;
use Madalynn\Bundle\MainBundle\Entity\Logcat;

use Faker\Factory as FakerFactory;

/**
 * Article
 *
 * @author Julien Brochet <mewt@androirc.com>
 */
class CrashReportFixtures extends AbstractFixture implements FixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param object $manager
     */
    public function load(ObjectManager $em)
    {
        $faker = FakerFactory::create();

        $cr = new CrashReport();

        $cr->setAndroidVersion('2.2.1');
        $cr->setAndroircVersion('3.1 e825cc1- build on 2011/11/26 17:31');
        $cr->setThreadName('main');
        $cr->setPhoneModel('Nexus 4');
        $cr->setErrorMessage('Fixtures crash report');
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

        for ($i = 0 ; $i < 4 ; $i++) {
            $logcat = new Logcat();
            $logcat->setLogcat(<<<EOF
01-15 19:50:01.521  1630  1630 I AndroIRC: Chosen theme: Classic
01-15 19:50:01.521  1630  1630 I AndroIRC: Premium app not found: ads enabled
01-15 19:50:01.521  1630  1630 I AndroIRC: Starting AndroIRC with action: android.intent.action.MAIN
01-15 19:50:01.521  1630  1630 I AndroIRC: [onCreate()] Creating user interface ...
01-15 19:50:01.540  1630  1630 I AndroIRC: [SQLAndroIRC::loadConfiguration] Configuration loaded in 16 ms
01-15 19:50:01.540  1630  1630 I AndroIRC: Service started? true
01-15 19:50:01.540  1630  1630 D AndroIRC: Theme name: Light
01-15 19:50:01.560  1630  1635 D dalvikvm: GC_CONCURRENT freed 296K, 5% free 8254K/8647K, paused 13ms+1ms, total 15ms
01-15 19:50:01.580  1630  1630 V AndroIRC: This is a message logged in VERBOSE
01-15 19:50:01.580  1630  1630 D AndroIRC: This is a message logged in DEBUG
01-15 19:50:01.580  1630  1630 I AndroIRC: This is a message logged in INFORMATION
01-15 19:50:01.580  1630  1630 W AndroIRC: This is a message logged in WARNING
01-15 19:50:01.580  1630  1630 E AndroIRC: This is a message logged in ERROR
01-15 19:50:01.580  1630  1630 D AndroidRuntime: Shutting down VM
01-15 19:50:01.590  1630  1630 W dalvikvm: threadid=1: thread exiting with uncaught exception (group=0xb3e8d288)
01-15 19:50:01.851  1630  1673 I AndroIRC: [BetaChecker] no new beta available
01-15 19:50:03.451  1630  1674 I AndroIRC: Crash report sent!
EOF
            );
            $cr->addLogCat($logcat);

            $em->persist($logcat);
        }

        $em->persist($cr);
        $em->flush();
    }
}
