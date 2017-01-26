<?php


namespace botmm\pack;


use botmm\common\qq_info;
use botmm\GradeeBundle\Oicq\Tools\Hex;
use TrafficCophp\ByteBuffer\Buffer;

class LoginPack
{
    /**
     * @var qq_info
     */
    public $qq;

    /**
     * @var Buffer
     */
    public $buffer;

    public $written = 0;

    public function __constructor()
    {
        $this->qq     = new qq_info();
        $this->buffer = new Buffer(32);
    }

    public function init()
    {

    }

    public function pack()
    {
        $this->qq->shareKey = "957C3AAFBF6FAF1D2C2F19A5EA04E51C";
        $this->qq->pub_key  = "957C3AAFBF6FAF1D2C2F19A5EA04E51C";
        $this->qq->TGTKey   = random_bytes(16);
        $this->qq->time     = time();

        $this->startPack();
    }

    public function startPack()
    {
        $this->buffer->write(Hex::HexStringToBin("00 09"), $this->written);
        $this->written += 2;
        $this->buffer->writeInt16BE(19, $this->written); //00 13
        $this->written += 2;


    }
}