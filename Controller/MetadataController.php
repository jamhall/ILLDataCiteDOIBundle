<?php

namespace ILL\DataCiteDOIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ILL\DataCiteDOIBundle\Form\Type\MetadataType;
use ILL\DataCiteDOIBundle\Model\Metadata;
use ILL\DataCiteDOIBundle\Model\Metadata\Title;

class MetadataController extends Controller
{
    /**
     * @Route("/{id}/metadata/edit.{_format}",defaults={"_format"="html"}, requirements={"_format"="html|json"}))
     * @Template()
     */
    public function editAction($id)
    {
        sleep(1);
        $doiRepository = $this->getDoctrine()->getRepository("ILLDataCiteDOIBundle:DOI");
        $doi = $doiRepository->findOneById($id);

        if(false == $doi) {
            throw $this->createNotFoundException(sprintf("Couldn't find the DOI with the id of %s", $id));
        }

        $metadataManager = $this->container->get("ill_data_cite_doi.metadata_manager");
        $metadata = $metadataManager->find($doi->getDOI());

        // serialize metadata object into JSON
        $serializer = new Serializer(array(new GetSetMethodNormalizer()), array(new JsonEncoder()));
        return new Response($serializer->serialize($metadata, 'json'));
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
