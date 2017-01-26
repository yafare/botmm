<?php


namespace botmm\BufferBundle\Buffer;



class StreamInputBuffer
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

    public function read($length)
    {
        $bytes = $this->buffer->read($this->offset, $length);
        $this->offset += $length;
        return $bytes;
    }

    public function readHex($length, $space = true)
    {
        $bytes = $this->buffer->readHex($this->offset, $length, $space);
        $this->offset += $length;
        return $bytes;
    }

    public function readInt8()
    {
        $this->buffer->readInt8($this->offset);
        $this->offset += 1;
    }

    public function readInt16BE()
    {
        $this->buffer->readInt16BE($this->offset);
        $this->offset += 2;
    }

    public function readInt16LE()
    {
        $this->buffer->readInt16LE( $this->offset);
        $this->offset += 2;
    }

    public function readInt32BE()
    {
        $this->buffer->readInt32BE( $this->offset);
        $this->offset += 4;
    }

    public function readInt32LE()
    {
        $this->buffer->readInt32LE( $this->offset);
        $this->offset += 4;
    }


    public function readInt64BE()
    {
        $this->buffer->readInt64BE($this->offset);
        $this->offset += 8;
    }

    public function readInt64LE()
    {
        $this->buffer->readInt64LE($this->offset);
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