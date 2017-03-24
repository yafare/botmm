<?php


namespace botmm\GradeeBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SocketClientCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('botmm:socket:client')
            ->setDescription(' Send a message using swoole socket')
            ->addArgument('name', InputArgument::REQUIRED, 'the protocol name of the client service')
            ->addOption('option', null, InputOption::VALUE_NONE, 'Option description');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');

        $clientId = sprintf('botmm.socket.%s.client', $name);

        $client = $this->getContainer()->get($clientId);

        $client->run();

    }

}