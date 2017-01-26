<?php


namespace botmm\GradeeBundle\Tlv;


class Tlv_t11c extends tlv_t
{
    public function __construct()
    {
        parent::__construct();
        $this->_cmd = 0x11c;
    }
}
