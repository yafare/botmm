<?php


namespace botmm\GradeeBundle\Oicq\Platform;


use botmm\GradeeBundle\Oicq\Tools\Hex;

class PlatformInformation
{
    public $androidDevice;
    public $apkInfo;


    public $readflg;        //imei readFlag
    public $imei  = "adfcrtghsfewagaw";           // 文本型
    public $imei_ = "adfcrtghsfewagaw";          // 字节集
    public $ver   = "5.8.0.157158";            // 字节集 ﻿ 5.8.0.157158
    public $appId;          // 整数型
    public $subAppId;          // 整数型
    public $pcVer = 8001;          // 文本型 0x02
    public $clientVersion;

    public $device;         // 文本型
    public $_apkId;        // 文本型
    public $_apkV;         // 文本型
    public $_apkSig;        // 字节集

    public $initTime;
    public $clientIp;
    public $sevePwd = 1;
    public $appid;
    public $wxAppId;
    public $ksid;

    public $osType;        // 文本型
    public $osVersion;     // 文本型
    public $_networkType;  // 整数型
    public $_apn;           // 文本型
    public $ostype;
    public $osver;
    public $nettype;
    public $netdetail;
    public $addr;
    public $apn;
    public $operator_name;
    public $network_type;

    public $readguid;
    public $guidchg;
    public $t128_flag;
    public $devicetype;

    public $local_id;

    public $appVer;
    public $appSign;

    public $time;
    public $version;

    public $android_id;

    public $requestId; //10000++

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