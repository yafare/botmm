<?php
namespace botmm\GradeeBundle\Tlv;


class tlv_t305 extends tlv_t {
    public function __construct()
	{
		parent::__construct();
        $this->_cmd = 773;
    }
}