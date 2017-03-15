<?php

namespace wx\WxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('wxWxBundle:Default:index.html.twig');
    }
}
