<?php


namespace src\wx\WxBundle\Tests\EasyWechat;


use EasyWeChat\Foundation\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use wx\WxBundle\EasyWechat\EasyWechatApplication;

class TestEasyWechat extends KernelTestCase
{

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var EasyWechatApplication
     */
    protected $wx;

    public function setUp()
    {
        self::bootKernel();
        $this->container = self::$kernel->getContainer();
        $this->wx = $this->container->get('wx_wx.easy_wechat.easy_wechat_application');
        parent::setUp();

    }

    public function testCreateApplication()
    {
        $wx = $this->container->get('wx_wx.easy_wechat.easy_wechat_application');
        $this->assertInstanceOf(Application::class, $wx->getApplication());
    }

    public function testParameters()
    {
        $app = $this->wx->getApplication();

        $this->assertEquals($this->container->getParameter('wx_config')['app_id'], $app['config']['app_id']);
    }
}