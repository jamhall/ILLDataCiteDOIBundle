<?php

namespace ILL\DataCiteDOIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class MetadataController extends Controller
{
    /**
     * @Route("/{id}/metadata/edit")
     * @Template()
     */
    public function editAction($id)
    {

    }

    /**
     * @Route("/metadata/create")
     * @Template()
     */
    public function createAction(Request $request)
    {

    }
}
