<?php


namespace botmm\GradeeBundle\Tlv;


use botmm\BufferBundle\Buffer\Buffer;

class  tlv_t191 extends tlv_t
{

    public function __construct()
    {
        parent::__construct();
        $this->_cmd = 401;
    }

    /**
     * @return mixed
     */
    public function get_tlv_191()
    {
        $body = new Buffer(1);
        $body->writeInt8(0, 0);
        $this->fill_head($this->_cmd);
        $this->fill_body($body, 1);
        $this->set_length();
        return $this->get_buf();
    }
}

