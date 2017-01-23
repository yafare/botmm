<?php


namespace botmm\GradeeBundle\Tests\Tlv;


use botmm\tools\Hex;
use PHPUnit_Framework_TestCase;

class TlvTestCase extends PHPUnit_Framework_TestCase
{

    protected function assertBinEqualsHex($expected, $actual, $message = "")
    {
        $expected = Hex::BinToHexString(hex2bin(preg_replace('/\s/', '', $expected)));
        $actual   = Hex::BinToHexString($actual);
        $this->assertEquals($expected, $actual, $message);
    }
}