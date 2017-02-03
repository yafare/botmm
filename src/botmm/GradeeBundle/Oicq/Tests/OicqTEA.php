<?php


namespace Cryptor;


use botmm\GradeeBundle\Oicq\Cypher\Cryptor;
use botmm\GradeeBundle\Oicq\Tools\Hex;
use botmm\GradeeBundle\Tests\Tlv\TlvTestCase;

class QicqTEA extends TlvTestCase
{

    public function testDec001()
    {
        $data = "
87 4b 33 00 b3 12 b9 4d 37 70 cc 96 f0 21 e8 c1 b3 5e 94 2a
d9 67 f2 cb e4 c3 8f 95 b6 e9 36 66 70 4f ae fd
e0 ed b9 74 59 c9 4a 4e 1d 59 c3 87 78 a5 d5 84
04 79 57 51 f8 36 1a 45 ce 46 3a 95 5d 2e b0 e0
7a d8 98 14 6d 12 69 cb 4a 23 4a 6a b4 13 f7 50
fe 1c 08 fb 69 5c 25 a0 2a 64 64 7b a2 03 52 b4
87 66 89 ce 48 e8 13 7b 6a ff d6 74 07 ed f5 0a
aa 89 ff 52 88 fa 79 59 18 d4 6f c7 ";
        //$key    = '4da0f614fc9f29c2054c77048a6566d7';
        //$key = '76 c9 a6 37 9c 3c 6d 8e 3c a9 5a 89 b3 d0 b8 67';
        //$key = '00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00';
        //$key  = '7d 1f fc 96 23 9d 17 a2 36 f1 22 d2 b4 97 a3 00';//sharekey
        $key = '2d 1a 25 bc 4c 96 9d 65 8b b6 ee 62 26 30 86 42 ';//md5_2+uin

        $str    = Hex::HexStringToBin($data);
        $result = Cryptor::decrypt($str, 0, strlen($str), Hex::HexStringToBin($key));

        $this->assertBinEqualsHex("0c", $result, "should equal");
    }
}