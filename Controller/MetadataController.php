<?php

namespace ILL\DataCiteDOIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ILL\DataCiteDOIBundle\Form\Type\MetadataType;
use ILL\DataCiteDOIBundle\Model\Metadata;
use ILL\DataCiteDOIBundle\Model\Metadata\Title;

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
        $metadata = new Metadata();
        $metadata->addTitle(new Title());
        $metadata->addTitle(new Title());

        $form = $this->createForm(new MetadataType(), $metadata);

        if ($request->getMethod()=='POST') {
            $form->bindRequest($request);
            if($form->isValid()) {
                var_dump($metadata);
            }
        }

        return array("form"=>$form->createView());
    }
}
