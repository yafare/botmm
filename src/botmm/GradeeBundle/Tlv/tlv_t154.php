<?php
namespace botmm\GradeeBundle\Tlv;

use botmm\BufferBundle\Buffer\Buffer;

class tlv_t154 extends tlv_t
{
    public function __construct()
	{
		parent::__construct();
        $this->_cmd = 340;
    }

    public function get_tlv_154($ssoSeq)
    {
        $body = new Buffer(4);
        $p    = 0;
        $body->writeInt32BE($ssoSeq, $p);
        $p += 4;
        $this->fill_head($this->_cmd);
        $this->fill_body($body, $p);
        $this->set_length();
        return $this->get_buf();
    }
}
