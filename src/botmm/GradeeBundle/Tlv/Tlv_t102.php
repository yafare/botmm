<?php


namespace botmm\GradeeBundle\Tlv;


class Tlv_t102 extends Tlv_t
{
    public function __construct()
	{
		parent::__construct();
        $this->_cmd = 0x102;
    }
}
