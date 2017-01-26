<?php


namespace botmm\GradeeBundle\Tlv;


class Tlv_t10e extends tlv_t
{
    public function __construct()
    {
        parent::__construct();
        $this->_cmd = 0x10e;
    }
}
