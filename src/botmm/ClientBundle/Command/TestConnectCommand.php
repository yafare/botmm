<?php

namespace botmm\ClientBundle\Command;

use botmm\GradeeBundle\Tlv\tlv_t18;
use botmm\tools\Hex;
use swoole_client;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use TrafficCophp\ByteBuffer\Buffer;

class TestConnectCommand extends ContainerAwareCommand
{
    public $uin;

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
        $loginBuffer = new Buffer(512);
        $offset      = 0;
        $loginBuffer->write(Hex::HexStringToBin("00 09"), $offset);
        $offset += 2;
        $loginBuffer->writeInt16BE(19, $offset); //tlv 个数
        $offset += 2;
        $loginBuffer->write($this->get_tlv18(), $offset);
        $loginBuffer->write($this->get_tlv1(), $offset);
    }




}
