<?php


namespace botmm\GradeeBundle\Tlv;


use botmm\BufferBundle\Buffer\Buffer;

class tlv_t10a extends tlv_t
{
    public function __constructor()
    {
        $this->_cmd = 0x10a;
    }

    public function get_tlv_10a($TGT)
    {
        $body = new Buffer(strlen($TGT));
        $body->write($TGT, 0);
        $this->fill_head($this->_cmd);
        $this->fill_body($body, strlen($body));
        $this->set_length();
        return $this->get_buf();
    }
}
