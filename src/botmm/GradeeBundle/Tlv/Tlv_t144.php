<?php


namespace botmm\GradeeBundle\Tlv;

use TrafficCophp\ByteBuffer\Buffer;

class tlv_t144 extends tlv_t {
    public $_t144_body_len;

    public function __constructor() {
        $this->_t144_body_len = 0;
        $this->_cmd = 324;
    }

    /**
     * @param byte[] $_109
     * @param byte[] $_124
     * @param byte[] $_128
     * @param byte[] $key
     * @return
     */
    public function get_tlv144_4($_109, $_124, $_128, $key) {
        $in_len = 0;
        $tlv_num = 0;
        $_109_len = strlen($_109);
        $_124_len = strlen($_124);
        $_128_len = strlen($_128);
        $_key = strlen($key);
        if ($_109 != null && $_109_len > 0) {
            $in_len += $_109_len;
            $tlv_num++;
        }
        if ($_124 != null && $_124_len > 0) {
            $in_len += $_124_len;
            $tlv_num++;
        }
        if ($_128 != null && $_128_len > 0) {
            $in_len += $_128_len;
            $tlv_num++;
        }
        $body = new Buffer($in_len + 2);
        $pos = 0;
        $body->writeInt16BE($tlv_num, $pos);
        $pos += 2;
        if ($_109 != null && $_109_len > 0) {
            $body->write($_109, $pos);
            $pos += $_109_len;
        }
        if ($_124 != null && $_124_len > 0) {
            $body->write($_124, $pos);
            $pos += $_124_len;
        }
        if ($_128 != null && $_128_len > 0) {
            $body->write($_128, $pos);
            $pos += $_128_len;
        }
        $body = cryptor.encrypt($body, 0, strlen($body), $key);
        $this->_t144_body_len = strlen($body);
        $this->fill_head($this->_cmd);
        $this->fill_body($body, strlen($body));
        $this->set_length();
        return $this->get_buf();
    }

    public function get_tlv144_5($_109, $_124, $_128, $_147, $key) {
        $in_len = 0;
        $tlv_num = 0;
        $_109_len = strlen($_109);
        $_124_len = strlen($_124);
        $_128_len = strlen($_128);
        $_147_len = strlen($_147);
        if ($_109 != null && $_109_len > 0) {
            $in_len = 0 + $_109_len;
            $tlv_num++;
        }
        if ($_124 != null && $_124_len > 0) {
            $in_len += $_124_len;
            $tlv_num++;
        }
        if ($_128 != null && $_128_len > 0) {
            $in_len += $_128_len;
            $tlv_num++;
        }
        if ($_147 != null && $_147_len > 0) {
            $in_len += $_147_len;
            $tlv_num++;
        }
        $body = new Buffer($in_len + 2);
        $pos = 0;
        $body->writeInt16BE($tlv_num, $pos);
        $pos += 2;
        if ($_109 != null && $_109_len > 0) {
            $body->write($_109, $pos);
            $pos += $_109_len;
        }
        if ($_124 != null && $_124_len > 0) {
            $body->write($_124, $pos);
            $pos += $_124_len;
        }
        if ($_128 != null && $_128_len > 0) {
            $body->write($_128, $pos);
            $pos += $_128_len;
        }
        if ($_147 != null && $_147_len > 0) {
            $body->write($_147, $pos);
            $pos += $_147_len;
        }
        $body = cryptor.encrypt($body, 0, strlen($body), $key);
        $this->_t144_body_len = strlen($body);
        $this->fill_head($this->_cmd);
        $this->fill_body($body, strlen($body));
        $this->set_length();
        return $this->get_buf();
    }

    public function get_tlv144_6( $_109, $_124, $_128, $_147, $_148, $key) {
        $in_len = 0;
        $tlv_num = 0;
        $_109_len = strlen($_109);
        $_124_len = strlen($_124);
        $_128_len = strlen($_128);
        $_147_len = strlen($_147);
        $_148_len = strlen($_148);
        if ($_109 != null && $_109_len > 0) {
            $in_len += $_109_len;
            $tlv_num++;
        }
        if ($_124 != null && $_124_len > 0) {
            $in_len += $_124_len;
            $tlv_num++;
        }
        if ($_128 != null && $_128_len > 0) {
            $in_len += $_128_len;
            $tlv_num++;
        }
        if ($_147 != null && $_147_len > 0) {
            $in_len += $_147_len;
            $tlv_num++;
        }
        if ($_148 != null && $_148_len > 0) {
            $in_len += $_148_len;
            $tlv_num++;
        }
        $body = new Buffer($in_len + 2);
        $pos = 0;
        $body->writeInt16BE($tlv_num, $pos);
        $pos += 2;
        if ($_109 != null && $_109_len > 0) {
            $body->write($_109, $pos);
            $pos += $_109_len;
        }
        if ($_124 != null && $_124_len > 0) {
            $body->write($_124, $pos);
            $pos += $_124_len;
        }
        if ($_128 != null && $_128_len > 0) {
            $body->write($_128, $pos);
            $pos += $_128_len;
        }
        if ($_147 != null && $_147_len > 0) {
            $body->write($_147, $pos);
            $pos += $_147_len;
        }
        if ($_148 != null && $_148_len > 0) {
            $body->write($_148, $pos);
            $pos += $_148_len;
        }
        $body = cryptor.encrypt($body, 0, strlen($body), $key);
        $this->_t144_body_len = strlen($body);
        $this->fill_head($this->_cmd);
        $this->fill_body($body, strlen($body));
        $this->set_length();
        return $this->get_buf();
    }

    public function get_tlv144_8($_109, $_124, $_128, $_147, $_148, $_151, $_153, $key) {
        $in_len = 0;
        $tlv_num = 0;
        $_109_len = strlen($_109);
        $_124_len = strlen($_124);
        $_128_len = strlen($_128);
        $_147_len = strlen($_147);
        $_148_len = strlen($_148);
        $_151_len = strlen($_151);
        $_153_len = strlen($_153);
        if ($_109 != null && $_109_len > 0) {
            $in_len += $_109_len;
            $tlv_num++;
        }
        if ($_124 != null && $_124_len > 0) {
            $in_len += $_124_len;
            $tlv_num++;
        }
        if ($_128 != null && $_128_len > 0) {
            $in_len += $_128_len;
            $tlv_num++;
        }
        if ($_147 != null && $_147_len > 0) {
            $in_len += $_147_len;
            $tlv_num++;
        }
        if ($_148 != null && $_148_len > 0) {
            $in_len += $_148_len;
            $tlv_num++;
        }
        if ($_151 != null && $_151_len > 0) {
            $in_len += $_151_len;
            $tlv_num++;
        }
        if ($_153 != null && $_153_len > 0) {
            $in_len += $_153_len;
            $tlv_num++;
        }
        $body = new Buffer($in_len + 2);
        $pos = 0;
        $body->writeInt16BE($tlv_num, $pos);
        $pos += 2;
        if ($_109 != null && $_109_len > 0) {
            $body->write($_109, $pos);
            $pos += $_109_len;
        }
        if ($_124 != null && $_124_len > 0) {
            $body->write($_124, $pos);
            $pos += $_124_len;
        }
        if ($_128 != null && $_128_len > 0) {
            $body->write($_128, $pos);
            $pos += $_128_len;
        }
        if ($_147 != null && $_147_len > 0) {
            $body->write($_147, $pos);
            $pos += $_147_len;
        }
        if ($_148 != null && $_148_len > 0) {
            $body->write($_148, $pos);
            $pos += $_148_len;
        }
        if ($_151 != null && $_151_len > 0) {
            $body->write($_151, $pos);
            $pos += $_151_len;
        }
        if ($_153 != null && $_153_len > 0) {
            $body->write($_153, $pos);
            $pos += $_153_len;
        }
        $body = cryptor.encrypt($body, 0, strlen($body), $key);
        $this->_t144_body_len = strlen($body);
        $this->fill_head($this->_cmd);
        $this->fill_body($body, strlen($body));
        $this->set_length();
        return $this->get_buf();
    }
}
