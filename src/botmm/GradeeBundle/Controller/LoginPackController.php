<?php


namespace botmm\GradeeBundle\Controller;


use botmm\GradeeBundle\Oicq\Tools\Hex;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * {@inheritDoc}
 */
class LoginPackController extends Controller
{

    /**
     * @Route("/loginpack")
     */
    public function index() {
        $loginPack = $this->get('botmm_gradee.pack.login');

        $data = $loginPack->pack();

        return new Response(Hex::BinToHexString($data));



    }


}