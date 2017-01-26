<?php


namespace botmm\GradeeBundle\Oicq\Tlv;


class tlv_t10b extends Tlv_t
{
    public function __construct()
    {
        parent::__construct();
        $this->_cmd = 0x10b;
    }
}
