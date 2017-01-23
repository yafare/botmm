<?php


namespace botmm\GradeeBundle\Tlv;


use botmm\BufferBundle\Buffer\Buffer;
use botmm\tools\Cryptor;

class tlv_t106 extends tlv_t {
    
    protected $_SSoVer;
    
    protected $_TGTGTVer;
    
    protected $_t106_body_len;

    public function __constructor()
    {
        $this->_TGTGTVer      = 1;
        $this->_SSoVer        = 1;
        $this->_t106_body_len = 69;
        $this->_cmd           = 262;
        $this->_SSoVer        = util . SSO_VERSION;
        if (util . SSO_VERSION <= 2) {
            $this->_TGTGTVer      = 1;
            $this->_t106_body_len = 69;
            return;
        }
        $this->_TGTGTVer      = 2;
        $this->_t106_body_len = 90;
    }

    /**
     * @param long $appid
     * @param int $client_ver
     * @param long $uin
     * @param byte[] $init_time
     * @param byte[] $client_ip
     * @param byte $seve_pwd
     * @param byte[] $md5
     * @param byte[] $TGTGT 3 ssover 5
     * @param int $readflg
     * @param byte[] $guid
     * @return mixed
     */
    public function get_tlv_106(
        $appid,
        $client_ver,
        $uin,
        $init_time,
        $client_ip,
        $seve_pwd,
        $md5,
        $TGTGT,
        $readflg,
        $guid
    ) {
        if (util . SSO_VERSION <= 2) {
            $body = new Buffer($this->_t106_body_len);
            $p    = 0;
            $body->writeInt16BE($this->_TGTGTVer, $p);
            $p += 2;
            $body->writeInt32BE(mt_rand(), $p);
            $p += 4;
            $body->writeInt32BE($this->_SSoVer, $p);
            $p += 4;
            $body->writeInt32BE($appid, $p);
            $p += 4;
            $body->writeInt32BE($client_ver, $p);
            $p += 4;
            $body->writeInt64BE($uin, $p);
            $p += 8;
            $body->write($init_time, $p);
            $p += strlen($init_time);
            $body->write($client_ip, $p);
            $p += strlen($client_ip);
            $body->writeInt8($seve_pwd, $p);
            $p++;
            $body->write($md5, $p);
            $p += strlen($md5);
            $body->write($TGTGT, $p);
            $p += strlen($TGTGT);
            $s2 = new Buffer(24);
            $s2->write($md5, 0);
            $s2->writeInt64BE($uin, 16);
            $body = Cryptor::encrypt($body, 0, strlen($body), MD5::toMD5Byte($s2));
            $this->_t106_body_len = strlen($body);
            $this->fill_head($this->_cmd);
            $this->fill_body($body, $this->_t106_body_len);
            $this->set_length();
            return $this->get_buf();
        }
    $body = new Buffer($this->_t106_body_len);
        $p = 0;
        $body->writeInt16BE($this->_TGTGTVer, $p);
        $p += 2;
        $body->writeInt32BE(mt_rand(), $p);
        $p += 4;
        $body->writeInt32BE($this->_SSoVer, $p);
        $p += 4;
        $body->writeInt32BE($appid, $p);
        $p += 4;
        $body->writeInt32BE($client_ver, $p);
        $p += 4;
        $body->writeInt64BE($uin, $p);
        $p += 8;
        $body->write($init_time, $p);
        $p += strlen($init_time);
        $body->write($client_ip, $p);
        $p += strlen($client_ip);
        $body->writeInt8($seve_pwd, $p);
        $p++;
        $body->write($md5, $p);
        $p += strlen($md5);
        $body->write($TGTGT, $p);
        $p += strlen($TGTGT);
        $body->writeInt32BE(0, $p);
        $p += 4;
        $body->writeInt8($readflg, $p);
        $p++;
    if ($guid == null || strlen($guid) <= 0) {
        $guid = new Buffer(16);
        $guid->writeInt32BE(mt_rand(), 0);
        $guid->writeInt32BE(mt_rand(), 4);
        $guid->writeInt32BE(mt_rand(), 8);
        $guid->writeInt32BE(mt_rand(), 12);
        $p += 16;
    } else {
        $body->write($guid, $p);
        $p += 16;
    }
    $s2 = new Buffer(24);
    $s2->write($md5, 0);
    $s2->writeInt32BE($uin, 16);
    $body = Cryptor::encrypt($body, 0, strlen($body), MD5::toMD5Byte($s2));
    $this->_t106_body_len = strlen($body);
    $this->fill_head($this->_cmd);
    $this->fill_body($body, $this->_t106_body_len);
    $this->set_length();
    return $this->get_buf();
}
}
