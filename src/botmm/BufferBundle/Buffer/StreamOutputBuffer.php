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

    public function write($string, $length = null)
    {
        $this->buffer->write($string, $this->offset, $length);
        if ($length == null) {
            $length = strlen($string);
        }
        $this->offset += $length;
    }

    public function writeHex($string, $length = null)
    {
        $this->buffer->writeHex($string, $this->offset, $length);
        if ($length == null) {
            $length = strlen(Hex::HexStringToBin($string));
        }
        $this->offset += $length;
    }

    public function writeInt8($value)
    {
        $this->buffer->writeInt8($value, $this->offset);
        $this->offset += 1;
    }

    public function writeInt16BE($value)
    {
        $this->buffer->writeInt16BE($value, $this->offset);
        $this->offset += 2;
    }

    public function writeInt16LE($value)
    {
        $this->buffer->writeInt16LE($value, $this->offset);
        $this->offset += 2;
    }

    public function writeInt32BE($value)
    {
        $this->buffer->writeInt32BE($value, $this->offset);
        $this->offset += 4;
    }

    public function writeInt32LE($value)
    {
        $this->buffer->writeInt32LE($value, $this->offset);
        $this->offset += 4;
    }


    public function writeInt64BE($value)
    {
        $this->buffer->writeInt64BE($value, $this->offset);
        $this->offset += 8;
    }

    public function writeInt64LE($value)
    {
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