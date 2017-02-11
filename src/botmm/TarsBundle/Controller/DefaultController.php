<?php

namespace botmm\TarsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('botmmTarsBundle:Default:index.html.twig');
    }
}
