<?php

namespace Inspect\ContainterBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('InspectContainterBundle:Default:index.html.twig');
    }

    /**
     * @Route("/demo", name="demo_index")
     * @Template("InspectContainterBundle:Default:demo.html.twig")
     */
    public function showAction()
    {
        $array = $this->getDoctrine()
                      ->getRepository('InspectContainterBundle:News')
                      ->findAll();

        $dataGrid = $this->get('datagrid.factory')->createDataGrid('news');
        $dataGrid->setData($array);

        return array(
            'datagrid' => $dataGrid->createView()
        );
    }
}
