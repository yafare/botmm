<?php

namespace test\Test001Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('testTest001Bundle:Default:index.html.twig');
    }
}
