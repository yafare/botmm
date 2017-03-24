<?php

use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Parameter;

/*

$container->setDefinition(
    'botmm_client.example',
    new Definition(
        'botmm\ClientBundle\Example',
        array(
            new Reference('service_id'),
            "plain_value",
            new Parameter('parameter_name'),
        )
    )
);

*/

$container->set('botmm.client.swoole_socket_connect_event', new Definition(
    'botmm\ClientBundle\Event\SwooleSocketConnectEvent'
));
