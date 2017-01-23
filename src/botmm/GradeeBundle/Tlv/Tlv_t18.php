<?php


namespace botmm\GradeeBundle\Tlv;


use TrafficCophp\ByteBuffer\Buffer;

class tlv_t18 extends tlv_t {
protected $_ping_version;
protected $_sso_version;
protected $_t18_body_len;

public function __constructor() {
    $this->_t18_body_len = 22;
    $this->_ping_version = 1;
    $this->_sso_version = 1536;
    $this->_cmd = 24;
}

    /**
     * @param long $appid 4byte
     * @param int  $client_version 00 00 00 00
     * @param long $uin qq number
     * @param int  $rc 00 00 00 00
     * @return mixed
     */
public function get_tlv_18($appid, $client_version, $uin, $rc) {
        $body = new Buffer($this->_t18_body_len);

        $p = 0;
        $body->writeInt16BE($this->_ping_version, $p);
        $p += 2;
        $body->writeInt32BE($this->_sso_version, $p);
        $p += 4;
        $body->writeInt32BE($appid, $p);
        $p += 4;
        $body->writeInt32BE($client_version, $p);
        $p += 4;
        $body->writeInt32BE($uin, $p);
        $p += 4;
        $body->writeInt32BE($rc, $p);
        $p += 2;
        $body->writeInt16BE(0, $p);
        $p += 2;
        $this->fill_head($this->_cmd);
        $this->fill_body($body, $this->_t18_body_len);
        $this->set_length();
        return $this->get_buf();
    }
}