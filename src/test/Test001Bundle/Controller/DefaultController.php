<?php

namespace test\Test001Bundle\Controller;

use React\Dns\Resolver\Factory as DnsResolverFactory;
use React\EventLoop\Factory as EventLoopFactory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('testTest001Bundle:Default:index.html.twig');
    }

    /**
     * @Route("/test001")
     */
    public function testAction()
    {
        $loop    = $this->get('teknoo.reactphp_bridge.vendor.loop');
        $factory = new DnsResolverFactory();
        $dns     = $factory->create('8.8.8.8', $loop);

        $dns->resolve('igor.io')
            ->then(function ($ip) {
                echo "Host: $ip\n";
            });

        return new Response("yes it is");
    }

}
