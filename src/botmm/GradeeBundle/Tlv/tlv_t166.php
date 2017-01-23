<?php
namespace botmm\GradeeBundle\Tlv;


use botmm\BufferBundle\Buffer\Buffer;

class tlv_t166 extends tlv_t {
    public function __construct()
	{
		parent::__construct();
        $this->_cmd = 358;
    }

    public function get_tlv_166($img_type) {
        $body = new Buffer(1);
        $pos = 0;
        $body->writeInt8($img_type, $pos);
        $pos += 1;
        $this->fill_head($this->_cmd);
        $this->fill_body($body, $pos);
        $this->set_length();
        return $this->get_buf();
    }
}