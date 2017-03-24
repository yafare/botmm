<?php


namespace botmm\GradeeBundle\Oicq\Tlv;


use botmm\BufferBundle\Buffer\Buffer;

class Tlv_t525 extends Tlv_t
{
    public function __construct()
    {
        parent::__construct();
        $this->_cmd = 0x525;
    }

    public function get_tlv_525($tlv522)
    {
        $body = new Buffer();
        $p    = 1;
        $body->writeInt16BE(1, $p);//tlv数量
        $p += 2;
        $body->write($tlv522, $p);
        $p += strlen($tlv522);
        $this->fill_head($this->_cmd);
        $this->fill_body($body, $p);
        $this->set_length();
        return $this->get_buf();
    }

}