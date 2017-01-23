<?php


namespace botmm\ClientBundle\Client;


use botmm\GradeeBundle\Tlv\tlv_t1;
use botmm\GradeeBundle\Tlv\tlv_t18;
use botmm\tools\Hex;

class Login
{

    protected $uin;
    protected $appid;
    protected $client_version;
    protected $client_ip;

    public function __construct($uin)
    {
        $this->uin = $uin;
    }

    public function get_tlv18()
    {
        return (new tlv_t18())->get_tlv_18(
            Hex::HexStringToBin('00 00 00 10'),
            Hex::HexStringToBin('00 00 00 00'),
            $this->uin,
            0
        );
    }

    public function get_tlv1()
    {
        return (new tlv_t1())->get_tlv_1(
            $this->uin,
            $this->client_ip
        );
    }
}