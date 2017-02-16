<?php


namespace botmm\Tars\Protocol\Tars\Tests\TarsInputStream;


use botmm\Tars\Protocol\Tars\TarsInputStream;
use botmm\Tars\Protocol\Tars\Tests\TarsTestCase;

class TarsInputStreamTagsTest extends TarsTestCase
{

    public function testWriteTags()
    {
        $stream = new TarsInputStream();
        $stream->writeByte(0, 1);
        $stream->writeByte(0, 2);
        $stream->writeByte(0, 3);
        $stream->writeByte(0, 4);

        $this->assertEquals(hex2bin('1c2c3c4c'), $stream->getByteBuffer());
    }

}