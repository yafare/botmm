<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('botmm_tars_homepage', new Route('/', array(
    '_controller' => 'botmmTarsBundle:Default:index',
)));

return $collection;
