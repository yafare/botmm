<?php

namespace botmm\GradeeBundle\Tests\Controller;

use botmm\tools\Hex;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HexTest extends \PHPUnit_Framework_TestCase
{

    public function testHex()
    {
        $this->assertEquals("example hex data",
                            Hex::HexStringToBin("6578616d706c65206865782064617461"),
                            "the hex to bin string should equal");
    }

    public function testHexWithSpace()
    {
        $this->assertEquals("example hex data",
                            Hex::HexStringToBin("65 78 61 6d 70 6c 65 20 68 65 78 20 64 61 74 61"),
                            "the hex with space to bin string should equal");
        $this->assertEquals("HUAWEI U9508",
                            Hex::HexStringToBin("48 55 41 57 45 49 20 55 39 35 30 38"),
                            "the hex with space to bin string should equal");
    }

    public function testBinToHex()
    {
        $this->assertEquals("65 78 61 6d 70 6c 65 20 68 65 78 20 64 61 74 61",
                            Hex::BinToHexString("example hex data"),
                            "the bin to hex string should equal");
    }
}
