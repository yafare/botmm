<?php

namespace botmm\GradeeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('botmmGradeeBundle:Default:index.html.twig');
    }
}
