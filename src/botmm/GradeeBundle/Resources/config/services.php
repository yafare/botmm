<?php

use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;


$container->addDefinitions(
    [
        'platform.device'      => new Definition('botmm\GradeeBundle\Oicq\Platform\AndroidDevice'),
        'platform.apk'         => new Definition('botmm\GradeeBundle\Oicq\Platform\ApkInfo'),
        'platform.information' => new Definition('botmm\GradeeBundle\Oicq\Platform\PlatformInformation',
                                                 [
                                                     new Reference('platform.device'),
                                                     new Reference('platform.apk')
                                                 ]),
        'platform.qq_info'     => new Definition('botmm\GradeeBundle\Oicq\Platform\QqInfo'),
    ]
);


$container->addDefinitions(
    [
        'tlv.t1'   => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t1'),
        'tlv.t2'   => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t2'),
        'tlv.t8'   => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t8'),
        'tlv.t10a' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t10a'),
        'tlv.t10b' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t10b'),
        'tlv.t10c' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t10c'),
        'tlv.t10d' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t10d'),
        'tlv.t10e' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t10e'),
        'tlv.t11a' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t11a'),
        'tlv.t11c' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t11c'),
        'tlv.t11d' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t11d'),
        'tlv.t11f' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t11f'),
        'tlv.t16a' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t16a'),
        'tlv.t16b' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t16b'),
        'tlv.t16e' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t16e'),
        'tlv.t18'  => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t18'),
        'tlv.t100' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t100'),
        'tlv.t102' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t102'),
        'tlv.t103' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t103'),
        'tlv.t104' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t104'),
        'tlv.t105' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t105'),
        'tlv.t106' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t106'),
        'tlv.t107' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t107'),
        'tlv.t108' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t108'),
        'tlv.t109' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t109'),
        'tlv.t113' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t113'),
        'tlv.t114' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t114'),
        'tlv.t116' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t116'),
        'tlv.t119' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t119'),
        'tlv.t120' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t120'),
        'tlv.t121' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t121'),
        'tlv.t122' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t122'),
        'tlv.t124' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t124'),
        'tlv.t125' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t125'),
        'tlv.t126' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t126'),
        'tlv.t128' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t128'),
        'tlv.t129' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t129'),
        'tlv.t130' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t130'),
        'tlv.t132' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t132'),
        'tlv.t133' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t133'),
        'tlv.t134' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t134'),
        'tlv.t135' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t135'),
        'tlv.t136' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t136'),
        'tlv.t138' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t138'),
        'tlv.t140' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t140'),
        'tlv.t141' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t141'),
        'tlv.t142' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t142'),
        'tlv.t143' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t143'),
        'tlv.t144' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t144'),
        'tlv.t145' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t145'),
        'tlv.t146' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t146'),
        'tlv.t147' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t147'),
        'tlv.t148' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t148'),
        'tlv.t149' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t149'),
        'tlv.t150' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t150'),
        'tlv.t151' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t151'),
        'tlv.t152' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t152'),
        'tlv.t153' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t153'),
        'tlv.t154' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t154'),
        'tlv.t164' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t164'),
        'tlv.t165' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t165'),
        'tlv.t166' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t166'),
        'tlv.t167' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t167'),
        'tlv.t169' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t169'),
        'tlv.t171' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t171'),
        'tlv.t177' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t177'),
        'tlv.t187' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t187'),
        'tlv.t188' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t188'),
        'tlv.t191' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t191'),
        'tlv.t194' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t194'),
        'tlv.t202' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t202'),
        'tlv.t305' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t305'),
        'tlv.t511' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t511'),
        'tlv.t516' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t516'),
        'tlv.t521' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t521'),
        'tlv.t522' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t522'),
        'tlv.t525' => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t525'),
        'tlv.ta'   => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_ta'),
        'tlv.tc'   => new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_tc'),
    ]
);
