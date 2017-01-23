<?php
namespace botmm\GradeeBundle\Tlv;


class Tlv_t164 extends tlv_t {
    public function __construct()
	{
		parent::__construct();
        $this->_cmd = 356;
    }
}
