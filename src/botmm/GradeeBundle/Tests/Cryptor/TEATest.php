<?php


namespace Cryptor;


use botmm\GradeeBundle\Oicq\Cypher\Cryptor;
use botmm\GradeeBundle\Oicq\Tools\Hex;
use botmm\GradeeBundle\Tests\Tlv\TlvTestCase;

class TEATest extends TlvTestCase
{

    public function testDec001()
    {
        $data = "
2a 2d 67 a5 cb 89
1c 8e 5e 3c 0b 7a 51 ed 22 31 c9 a7 7f 66 6e 88
63 b2 24 b1 38 62 74 a6 b2 41 b6 89 30 6b 38 fb
74 e5 ca 98 1c cc 4b 97 7c 23 b3 56 5a 9b 29 6b
f3 b6 4c 42 5e 85 94 77 92 93 e2 e0 41 27 b2 ec
79 58 aa 6d 10 a4 c4 0f 18 e0 54 70 82 6b 58 bc
6e 6f 66 75 b1 5f 5d a4 f2 cc 26 07 61 b6 8b 90
af 39 06 95 35 07 4e 94 85 0b 86 ee f6 6d ed 11
60 c7 ";
        //$key    = '4da0f614fc9f29c2054c77048a6566d7';
        //$key = '76 c9 a6 37 9c 3c 6d 8e 3c a9 5a 89 b3 d0 b8 67';
        //$key = '00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00';
        //$key  = '7d 1f fc 96 23 9d 17 a2 36 f1 22 d2 b4 97 a3 00';//sharekey
        $key = '74ccb6a8c92f95de435fa9c329f2c816';//md5_2+uin

        $str    = Hex::HexStringToBin($data);
        $result = Cryptor::decrypt($str, 0, strlen($str), Hex::HexStringToBin($key));

        $this->assertBinEqualsHex("0c", $result, "should equal");
    }
}