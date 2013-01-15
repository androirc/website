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
            $logcat->setLogcat($faker->paragraph(5));
            $cr->addLogCat($logcat);

            $em->persist($logcat);
        }

        $em->persist($cr);
        $em->flush();
    }
}
