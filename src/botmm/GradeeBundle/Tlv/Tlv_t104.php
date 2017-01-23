<?php


namespace botmm\GradeeBundle\Tlv;


use botmm\BufferBundle\Buffer\Buffer;

class tlv_t104 extends tlv_t
{
    protected $_t104_body_len;

    public function __constructor()
    {
        $this->_t104_body_len = 0;
        $this->_cmd           = 0x104;
    }

    public function get_tlv_104($sig_session)
    {
        $this->_t104_body_len = strlen($sig_session);
        $body                 = new Buffer($this->_t104_body_len);
        $body->write($sig_session, 0);
        $this->fill_head($this->_cmd);
        $this->fill_body($body, $this->_t104_body_len);
        $this->set_length();
        return $this->get_buf();
    }
}
