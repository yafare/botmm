<?php


namespace botmm\GradeeBundle\Tlv;


use TrafficCophp\ByteBuffer\Buffer;

class Tlv_t16e extends tlv_t
{

    protected $_t16e_body_len;

    public function __constructor()
    {
        $this->_t16e_body_len = 0;
        $this->_cmd           = 366;
    }

    /**
     * @param byte[] $device
     * @return mixed
     */
    public function get_tlv_16e($device)
    {
        $i = 64;
        if($device == null) {
            $device = new Buffer(0);
        }
        if(strlen($device) < $i) {
            $i = strlen($device);
        }
        $this->_t16e_body_len = $i;
        $body                 = new Buffer($this->_t16e_body_len);
        $body->write($device, 0);
        $this->fill_head($this->_cmd);
        $this->fill_body($body, $this->_t16e_body_len);
        $this->set_length();
        return $this->get_buf();
    }
}
