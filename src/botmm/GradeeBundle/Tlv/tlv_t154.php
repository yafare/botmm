<?php
namespace botmm\GradeeBundle\Tlv;

use TrafficCophp\ByteBuffer\Buffer;

class tlv_t154 extends tlv_t
{
    public function __constructor()
    {
        $this->_cmd = 340;
    }

    public function get_tlv154($ssoSeq)
    {
        $body = new Buffer(4);
        $p    = 0;
        $body->writeInt32BE($ssoSeq, $p);
        $p += 4;
        $this->fill_head($this->_cmd);
        $this->fill_body($body, strlen($body));
        $this->set_length();
        return $this->get_buf();
    }
}
