<?php

use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;


$container->addDefinitions(
    [
        'platform.device'      => new Definition('botmm\GradeeBundle\Platform\AndroidDevice'),
        'platform.apk'         => new Definition('botmm\GradeeBundel\Platform\ApkInfo'),
        'platform.information' => new Definition('botmm\GradeeBundle\Platform\PlatformInformation',
                                                 [
                                                     new Reference('platform.device'),
                                                     new Reference('platform.apk')
                                                 ]),
    ]
);


$container->addDefinitions(
    [
        'Tlv.t1'   => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t1'),
        'Tlv.t2'   => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t2'),
        'Tlv.t8'   => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t8'),
        'Tlv.t10a' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t10a'),
        'Tlv.t10b' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t10b'),
        'Tlv.t10c' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t10c'),
        'Tlv.t10d' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t10d'),
        'Tlv.t10e' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t10e'),
        'Tlv.t11a' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t11a'),
        'Tlv.t11c' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t11c'),
        'Tlv.t11d' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t11d'),
        'Tlv.t11f' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t11f'),
        'Tlv.t16a' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t16a'),
        'Tlv.t16b' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t16b'),
        'Tlv.t16e' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t16e'),
        'Tlv.t18'  => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t18'),
        'Tlv.t100' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t100'),
        'Tlv.t102' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t102'),
        'Tlv.t103' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t103'),
        'Tlv.t104' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t104'),
        'Tlv.t105' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t105'),
        'Tlv.t106' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t106'),
        'Tlv.t107' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t107'),
        'Tlv.t108' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t108'),
        'Tlv.t109' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t109'),
        'Tlv.t113' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t113'),
        'Tlv.t114' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t114'),
        'Tlv.t116' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t116'),
        'Tlv.t119' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t119'),
        'Tlv.t120' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t120'),
        'Tlv.t121' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t121'),
        'Tlv.t122' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t122'),
        'Tlv.t124' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t124'),
        'Tlv.t125' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t125'),
        'Tlv.t126' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t126'),
        'Tlv.t128' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t128'),
        'Tlv.t129' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t129'),
        'Tlv.t130' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t130'),
        'Tlv.t132' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t132'),
        'Tlv.t133' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t133'),
        'Tlv.t134' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t134'),
        'Tlv.t135' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t135'),
        'Tlv.t136' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t136'),
        'Tlv.t138' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t138'),
        'Tlv.t140' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t140'),
        'Tlv.t141' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t141'),
        'Tlv.t142' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t142'),
        'Tlv.t143' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t143'),
        'Tlv.t144' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t144'),
        'Tlv.t145' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t145'),
        'Tlv.t146' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t146'),
        'Tlv.t147' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t147'),
        'Tlv.t148' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t148'),
        'Tlv.t149' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t149'),
        'Tlv.t150' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t150'),
        'Tlv.t151' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t151'),
        'Tlv.t152' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t152'),
        'Tlv.t153' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t153'),
        'Tlv.t154' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t154'),
        'Tlv.t164' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t164'),
        'Tlv.t165' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t165'),
        'Tlv.t166' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t166'),
        'Tlv.t167' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t167'),
        'Tlv.t169' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t169'),
        'Tlv.t171' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t171'),
        'Tlv.t177' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t177'),
        'Tlv.t187' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t187'),
        'Tlv.t188' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t188'),
        'Tlv.t191' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t191'),
        'Tlv.t305' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t305'),
        'Tlv.ta'   => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_ta'),
        'Tlv.tc'   => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_tc'),
    ]
);
