<?php
namespace botmm\GradeeBundle\Tlv;

use TrafficCophp\ByteBuffer\Buffer;

class tlv_t151 extends tlv_t {
    public function __constructor() {
        $this->_cmd = 337;
    }

    public function get_tlv151($data) {
        $body_len = 0;
        if ($data != null) {
            $body_len = strlen($data);
        }
        $body = new Buffer($body_len);
        if ($body_len > 0) {
            $body ->write($data, 0, $body_len);
        }
        $this->fill_head($this->_cmd);
        $this->fill_body($body, strlen($body));
        $this->set_length();
        return $this->get_buf();
    }
}
