<?php

namespace botmm\ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('botmmClientBundle:Default:index.html.twig');
    }
}
