<?php


namespace botmm\GradeeBundle\Tlv;


class Tlv_t114 extends tlv_t
{
    public function __construct()
    {
        parent::__construct();
        $this->_cmd = 0x114;
    }
}
