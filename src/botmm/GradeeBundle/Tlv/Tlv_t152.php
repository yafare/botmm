<?php
namespace botmm\GradeeBundle\Tlv;

class Tlv_t152 extends tlv_t
{
    public function __construct()
	{
		parent::__construct();
        $this->_cmd = 338;
    }
}