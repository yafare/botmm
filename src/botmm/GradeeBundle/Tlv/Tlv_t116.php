<?php


namespace botmm\GradeeBundle\Tlv;


use botmm\BufferBundle\Buffer\Buffer;

class tlv_t116 extends tlv_t
{
    /** @var int _t116_body_len */
    protected $_t116_body_len;
    /** @var int _ver */
    protected $_ver;

    public function __constructor()
    {
        $this->_t116_body_len = 0;
        $this->_ver           = 0;
        $this->_cmd           = 278;
    }

    /**
     * @param int    $bitmap
     * @param int    $get_sig ,
     * @param long[] appid
     * @return byte[]
     */
    public function get_tlv_116($bitmap, $get_sig, $appid)
    {
        if ($appid == null) {
            $tappid = new long[0];
        } else {
            $tappid = $appid;
        }
        $this -> _t116_body_len = (strlen($tappid) * 4) + 10;
        $p = 0;
        $body = new Buffer($this->_t116_body_len);
        $body->writeInt8($this->_ver, $p);
        $p += 1;
        $body->writeInt32BE($bitmap, $p);
        $p += 4;
        $body->writeInt32BE($get_sig, $p);
        $p += 4;
        $body->writeInt8(strlen($tappid), $p);
        $p++;
        for ($j = 0 ; $j < count($appid); $j++ ) {
            $body->writeInt32BE($appid[$j], $p);
            $p += 4;
        }
        $this->fill_head($this -> _cmd);
        $this->fill_body($body, $this -> _t116_body_len);
        $this->set_length();
        return $this->get_buf();
    }
}
