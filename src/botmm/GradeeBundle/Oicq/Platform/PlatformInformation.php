<?php


namespace botmm\GradeeBundle\Oicq\Platform;


use botmm\GradeeBundle\Oicq\Tools\Hex;
use botmm\GradeeBundle\Oicq\Tools\Util;

class PlatformInformation
{
    public $androidDevice;
    public $apkInfo;


    public $readflg;        //imei readFlag
    public $imei          = "d1 61 60 d5 b3 56 a0 a5 4f b9 93 24 a3 63 28 6b";           // 文本型
    public $imei_         = "adfcrtghsfewagaw";          // 字节集
    public $ver           = "5.8.0.157158";            // 字节集 ﻿ 5.8.0.157158
    public $appId         = 0x00000010;          // 整数型
    public $subAppId      = 0x2002ba7a;          // 整数型
    public $pcVer         = 0x1F41;          // 文本型 0x02
    public $clientVersion = 0x00000000;

    public $device = "a3 13 8a 8d d1 7e e1 a5 84 63 d7 56 83 18 0e 87";         // 文本型
    public $_apkId = "com.tencent.mobileqq";        // 文本型
    public $_apkV;         // 文本型
    public $_apkSig;        // 字节集

    public $initTime;
    public $clientIp;
    public $sevePwd = 1;
    public $appid   = 0x00000010;
    public $wxAppId = 0x2002ba7a;
    public $ksid;

    public $osType        = "android";        // 文本型
    public $osVersion     = "4.4.2";     // 文本型
    public $_networkType  = 0x0002;  // 整数型 1表示行动网络 2表示wifi
    public $_apn          = "wifi";           // 文本型
    public $ostype        = "android";
    public $osver         = "4.4.2";
    public $nettype       = 0x0002;
    public $apn           = "wifi";
    public $netdetail     = "CMCC";
    public $addr;
    public $operator_name = "CMCC";
    public $network_type  = 0x0002;

    public $readguid   = "d1 61 60 d5 b3 56 a0 a5 4f b9 93 24 a3 63 28 6b";
    public $guidchg;
    public $t128_flag  = 0x01000000;
    public $devicetype = "MI 4LTE";
    public $deviceName = "Xiaomi";

    public $local_id = 0x00000804;

    public $appVer  = "6.6.9";
    public $appSign = "a6 b7 45 bf 24 a2 c2 77 52 77 16 f6 f3 6e b6 8d";

    public $time;
    public $version = "6.3.1.1993";

    public $android_id = "90 06 af 4d 14 8c 18 22 88 1f 7e fe 8e 6d f2 39";

    public $requestId;//10000++

    public $ssoVer = Util::SSO_VERSION;

    public $ssoSeq      = 0x00016a91;
    public $userDomains = [
        "tenpay.com",
        "qzone.qq.com",
        "qun.qq.com",
        "mail.qq.com",
        "openmobile.qq.com",
        "qzone.com",
        "game.qq.com"
    ];
    //md5(imsi)
    public $imsi = "5f 64 aa b8 ed a2 e7 73 ca 1d 79 5d e6 19 19 68";
    //md5(bassaddr)
    public $bassaddr     = "fa db fa d6 6e f7 15 71 bd 7b 99 2d 9d 9c 5d b7";
    public $ssid         = "AndroidAP";
    public $source_type  = 0x00000000;
    public $product_type = 0x00000000;

    public function __construct(
        $androidDevice,
        $apkInfo
    ) {
        $this->androidDevice = $androidDevice;
        $this->apkInfo       = $apkInfo;

        $this->init();
    }

    public function init()
    {
        $this->ksid = Hex::HexStringToBin("93 33 4E AD B8 08 D3 42 82 55 B7 EF 28 E7 E8 F5");
    }

}