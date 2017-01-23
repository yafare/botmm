<?php

namespace botmm\BufferBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('botmmBufferBundle:Default:index.html.twig');
    }
}
