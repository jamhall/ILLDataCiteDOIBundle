<?php

namespace ILL\DataCiteDOIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AdminController extends Controller
{
    /**
     * @Route("/doissss")
     * @Template()
     */
    public function indexAction()
    {
        $doiRepository = $this->getDoctrine()->getRepository("ILLDataCiteDOIBundle:DOI");

        return array("dois"=>$doiRepository->findBy(array(), array("created"=>"DESC")));
    }
}
