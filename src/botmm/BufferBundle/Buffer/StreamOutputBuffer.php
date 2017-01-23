<?php


namespace botmm\BufferBundle\Buffer;


use botmm\tools\Hex;

class StreamOutputBuffer
{

    /**
     * @var Buffer
     */
    protected $buffer;
    protected $offset = 0;

    public function __construct($buffer)
    {
        $this->buffer = $buffer;
    }

    protected function checkCapacity($length)
    {
        $capacity = $this->buffer->getBufferCapacity();
        if ($this->offset + $length > $capacity) {
            $this->buffer->expand($capacity + 64);
        }
    }

    public function write($string, $length = null)
    {
        if ($length == null) {
            $length = strlen($string);
        }
        $this->checkCapacity($length);
        $this->buffer->write($string, $this->offset, $length);
        $this->offset += $length;
    }

    public function writeHex($string, $length = null)
    {
        if ($length == null) {
            $length = strlen(Hex::HexStringToBin($string));
        }
        $this->checkCapacity($length);
        $this->buffer->writeHex($string, $this->offset, $length);
        $this->offset += $length;
    }

    public function writeInt8($value)
    {
        $this->checkCapacity(1);
        $this->buffer->writeInt8($value, $this->offset);
        $this->offset += 1;
    }

    public function writeInt16BE($value)
    {
        $this->checkCapacity(2);
        $this->buffer->writeInt16BE($value, $this->offset);
        $this->offset += 2;
    }

    public function writeInt16LE($value)
    {
        $this->checkCapacity(2);
        $this->buffer->writeInt16LE($value, $this->offset);
        $this->offset += 2;
    }

    public function writeInt32BE($value)
    {
        $this->checkCapacity(4);
        $this->buffer->writeInt32BE($value, $this->offset);
        $this->offset += 4;
    }

    public function writeInt32LE($value)
    {
        $this->checkCapacity(4);
        $this->buffer->writeInt32LE($value, $this->offset);
        $this->offset += 4;
    }


    public function writeInt64BE($value)
    {
        $this->checkCapacity(8);
        $this->buffer->writeInt64BE($value, $this->offset);
        $this->offset += 8;
    }

    public function writeInt64LE($value)
    {
        $this->checkCapacity(8);
        $this->buffer->writeInt64LE($value, $this->offset);
        $this->offset += 8;
    }

    public function getBytes()
    {
        return $this->buffer->read(0, $this->offset);
    }

    public function getBuffer()
    {
        return $this->buffer;
    }

    public function getOffset()
    {
        return $this->offset;
    }

}