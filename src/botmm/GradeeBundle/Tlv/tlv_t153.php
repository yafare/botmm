<?php
namespace botmm\GradeeBundle\Tlv;


use TrafficCophp\ByteBuffer\Buffer;

class tlv_t153 extends tlv_t
{
    public function __constructor()
    {
        $this->_cmd = 339;
    }

    public function get_tlv153($isRoot)
    {
        $body = new Buffer(2);
        $p    = 0;
        $body->writeInt16BE($isRoot, $p);
        $p += 2;
        $this->fill_head($this->_cmd);
        $this->fill_body($body, strlen($body));
        $this->set_length();
        return $this->get_buf();
    }
}
