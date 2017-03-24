<?php


namespace botmm\GradeeBundle\Pack;


use botmm\BufferBundle\Buffer\Buffer;
use botmm\BufferBundle\Buffer\StreamOutputBuffer;
use botmm\GradeeBundle\Oicq\Cypher\Cryptor;

class Make_login_sendSsoMsg
{

    public $str = "wtlogin.login";


    private function Make_login_sendSsoMsg(
        $serviceCmd,
        $wupBuffer,
        $extBin,
        $imei,
        $ksid,
        $ver,
        $isLogin
    ) {
        $msgCookie = "﻿B6 CC 78 FC";

        $pack = new StreamOutputBuffer(new Buffer());
        $pack->writeInt32BE(
            4 + 4 + 4 + 4 + 12 +
            4 + strlen($extBin) +
            4 + strlen($serviceCmd) +
            4 + strlen($msgCookie) +
            4 + strlen($imei) +
            4 + strlen($ksid) +
            2 + strlen($ver)
        );
        $pack->writeInt32BE($this->global->requestId);
        $pack->writeInt32BE(0x20029f53);
        $pack->writeInt32BE(0x20029f53);
        //new 71 00 00 00 00 00 00 00 00 00 00 00
        $pack->writeHex("01 00 00 00 00 00 00 00 00 00 00 00");
        $pack->writeInt32BE(strlen($extBin));
        $pack->write($extBin, strlen($extBin));
        $pack->writeInt32BE(strlen($serviceCmd) + 4);
        $pack->write($serviceCmd);
        $pack->writeInt32BE(strlen($msgCookie) + 4);
        $pack->write($msgCookie);
        $pack->writeInt32BE(strlen($imei) + 4);
        $pack->write($imei);
        $pack->writeInt32BE(strlen($ksid) + 4);
        $pack->write($ksid);
        $pack->writeInt16BE(strlen($ver) + 2);
        $pack->write($ver);
        //new write something here

        $pack->writeInt32BE(strlen($wupBuffer) + 4);
        $pack->write($wupBuffer);
        $encrypt = Cryptor::encrypt($pack->getBytes(), 0, $pack->getLength(), $this->qq_info->key);
        return $isLogin ? $encrypt . hex2bin("00") : $encrypt . hex2bin("01");
    }
}