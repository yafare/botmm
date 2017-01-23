<?php

namespace botmm\ClientBundle\Command;

use botmm\BufferBundle\Buffer\Buffer;
use botmm\BufferBundle\Buffer\StreamOutputBuffer;
use botmm\GradeeBundle\Tlv\tlv_t1;
use botmm\GradeeBundle\Tlv\tlv_t100;
use botmm\GradeeBundle\Tlv\tlv_t106;
use botmm\GradeeBundle\Tlv\tlv_t107;
use botmm\GradeeBundle\Tlv\tlv_t108;
use botmm\GradeeBundle\Tlv\tlv_t109;
use botmm\GradeeBundle\Tlv\tlv_t116;
use botmm\GradeeBundle\Tlv\tlv_t124;
use botmm\GradeeBundle\Tlv\tlv_t128;
use botmm\GradeeBundle\Tlv\tlv_t144;
use botmm\GradeeBundle\Tlv\Tlv_t16e;
use botmm\GradeeBundle\Tlv\tlv_t18;
use botmm\tools\Hex;
use swoole_client;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class TestConnectCommand extends ContainerAwareCommand
{
    public    $uin;
    protected $qq_info;
    protected $global;

    protected function configure()
    {
        $this
            ->setName('botmm:TestConnect')
            ->setDescription('...')
            ->addArgument('argument', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option', null, InputOption::VALUE_NONE, 'Option description');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $argument = $input->getArgument('argument');

        if ($input->getOption('option')) {
            // ...
        }

        $output->writeln('Command result.');

        $this->createClient();

    }

    protected function createClient()
    {

        swoole_async_dns_lookup('msfwifi.3g.qq.com', function ($host, $ip) {
            $client = new swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);

            //注册连接成功回调
            $client->on("connect", function ($cli) {
                $cli->send($this->packLogin());
            });

            //注册数据接收回调
            $client->on("receive", function ($cli, $data) {
                echo "Received: " . $data . "\n";
            });

            //注册连接失败回调
            $client->on("error", function ($cli) {
                echo "Connect failed\n";
            });

            //注册连接关闭回调
            $client->on("close", function ($cli) {
                echo "Connection close\n";
            });

            //发起连接
            $client->connect($ip, 8080, 0.5);
        });
    }

    private function packLogin()
    {
        $this->qq_info = $this->getContainer()->get('qq_info');
        $this->global  = $this->getContainer()->get('global');
        $buffer        = new Buffer();
        $loginBuffer   = new StreamOutputBuffer($buffer);
        $loginBuffer->writeHex("00 09");
        $loginBuffer->writeInt16BE(19); //tlv 个数
        $loginBuffer->write($this->get_tlv18());
        $loginBuffer->write($this->get_tlv1());
        $loginBuffer->write($this->get_tlv106());
        $loginBuffer->write($this->get_tlv116());
        $loginBuffer->write($this->get_tlv100());
        $loginBuffer->write($this->get_tlv107());
        $loginBuffer->write($this->get_tlv108());
        $loginBuffer->write($this->get_tlv144());
        $loginBuffer->write($this->get_tlv142());
        $loginBuffer->write($this->get_tlv145());
        $loginBuffer->write($this->get_tlv141());
        $loginBuffer->write($this->get_tlv8());
        $loginBuffer->write($this->get_tlv16b());
        $loginBuffer->write($this->get_tlv147());
        $loginBuffer->write($this->get_tlv177());
        $loginBuffer->write($this->get_tlv187());
        $loginBuffer->write($this->get_tlv188());
        $loginBuffer->write($this->get_tlv191());

    }

    public function get_tlv144()
    {
        $tlv109 = $this->get_tlv109();
        $tlv124 = $this->get_tlv124();
        $tlv128 = $this->get_tlv128();
        $tlv16e = $this->get_tlv16e();

        $tlv = new tlv_t144();
        return $tlv->get_tlv_144($tlv109, $tlv124, $tlv128, $tlv16e, $this->qq_info->TGTKey);
    }

    public function get_tlv18()
    {
        $tlv = new tlv_t18();
        return $tlv->get_tlv_18(
            $this->qq_info->appid,
            $this->qq_info->client_version,
            $this->qq_info->uin,
            0);
    }

    public function get_tlv1()
    {
        $tlv = new tlv_t1();
        return $tlv->get_tlv_1(
            $this->qq_info->uin,
            $this->qq_info->client_ip
        );
    }

    public function get_tlv106()
    {
        $tlv = new tlv_t106();
        return $tlv->get_tlv_106(
            $this->global->appid,
            $this->global->subAppId,
            $this->global->client_ver,
            $this->qq_info->uin,
            $this->qq_info->init_time,
            $this->qq_info->client_ip,
            $this->global->seve_pwd,
            $this->qq_info->md5,
            //$uin,
            //$mUserAccount,
            $this->qq_info->TGTGT,
            $this->global->readflg,//readflg, imei readflag
            $this->global->imei
        );
    }

    private function get_tlv116()
    {
        $tlv = new tlv_t116();
        return $tlv->get_tlv_116(
            $this->qq_info->bitmap,
            $this->qq_info->get_sig,
            $this->global->appid
        );
    }

    private function get_tlv100()
    {
        $tlv = new tlv_t100();
        return $tlv->get_tlv_100(
            $this->global->appid,
            $this->global->wxappid,
            $this->global->client_ver,
            $this->qq_info->get_sig
        );
    }

    private function get_tlv107()
    {
        $tlv = new tlv_t107();
        return $tlv->get_tlv_107(
            $this->qq_info->pic_type,
            $this->qq_info->cap_type,
            $this->qq_info->pic_size,
            $this->qq_info->ret_type
        );
    }

    private function get_tlv108()
    {
        $tlv = new tlv_t108();
        return $tlv->get_tlv_108(
            $this->global->ksid
        );
    }

    private function get_tlv109()
    {
        $tlv = new tlv_t109();
        return $tlv->get_tlv_109(
            $this->global->imei
        );
    }

    private function get_tlv124()
    {
        $tlv = new tlv_t124();
        return $tlv->get_tlv_124(
            $this->global->ostype,
            $this->global->osver,
            $this->global->nettype,
            $this->global->netdetail,
            $this->global->addr,
            $this->global->apn
        );
    }

    private function get_tlv128()
    {
        $tlv = new tlv_t128();
        return $tlv->get_tlv_128(
            $this->qq_info->newins,
            $this->global->readguid,
            $this->global->guidchg,
            $this->global->t128_flag,
            $this->global->devicetype,
            $this->global->imei
        );
    }

    private function get_tlv16e()
    {
        $tlv = new tlv_t16e();
        return $tlv->get_tlv_16e(
            $this->global->device
        );
    }


}
