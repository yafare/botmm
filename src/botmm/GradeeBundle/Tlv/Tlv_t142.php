<?php


namespace botmm\GradeeBundle\Tlv;


use TrafficCophp\ByteBuffer\Buffer;

class tlv_t142 extends tlv_t {
    protected $_t142_body_len;
    protected $_version;

    public function __constructor() {
    $this->_version = 0;
    $this->_t142_body_len = 0;
    $this->_cmd = 322;
    }

    /**
     * @param $id ﻿_apk_id
     * @return mixed
     */
    public function get_tlv142($id) {
        $id_len = strlen($id);
        $this->_t142_body_len = $id_len + 4;
        $body = new Buffer($this->_t142_body_len);
        $pos = 0;
        $body->writeInt16BE($this->_version, $pos);
        $pos += 2;
        $body->writeInt16BE($id_len, $pos);
        $pos += 2;
        $body->write($id, $pos);
        $pos += $id_len;
        $this->fill_head($this->_cmd);
        $this->fill_body($body, strlen($body));
        $this->set_length();
        return $this->get_buf();
    }
}
