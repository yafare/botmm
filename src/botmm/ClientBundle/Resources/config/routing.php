<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('botmm_client_homepage', new Route('/', array(
    '_controller' => 'botmmClientBundle:Default:index',
)));

return $collection;
