<?php


namespace botmm\GradeeBundle\Oicq\Tlv;


class tlv_t10c extends Tlv_t
{
    public function __construct()
    {
        parent::__construct();
        $this->_cmd = 0x10c;
    }
}
