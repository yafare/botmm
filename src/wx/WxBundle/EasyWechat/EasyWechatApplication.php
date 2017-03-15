<?php


namespace wx\WxBundle\EasyWechat;


use EasyWeChat\Foundation\Application;

class EasyWechatApplication
{

    /**
     * @var Application
     */
    public $application;

    public function __construct($options)
    {
        $this->application = new Application($options);

    }

    /**
     * @return Application
     */
    public function getApplication()
    {
        return $this->application;
    }

}