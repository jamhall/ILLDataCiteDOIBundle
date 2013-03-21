<?php
/*
* This file is part of the ILLDataCiteDOIBundle package.
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*
* @License  MIT License
*/

namespace ILL\DataCiteDOIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ILL\DataCiteDOIBundle\Model\Metadata;

class MetadataController extends Controller
{
    /**
     * @Route("/dois/{id}/metadata/edit")
     * @Template()
     */
    public function editAction($id)
    {
        $doiRepository = $this->getDoctrine()->getRepository("ILLDataCiteDOIBundle:DOI");
        $doi = $doiRepository->findOneById($id);

        if (false == $doi) {
            throw $this->createNotFoundException(sprintf("Couldn't find the DOI with the id of %s", $id));
        }

        return array("doi"=>$doi);
    }

    /**
     * @Route("/metadata/create")
     * @Template()
     */
    public function createAction(Request $request)
    {
        return array();
    }

    /**
     * @Route("/dois/{id}/metadata.{_format}",defaults={"_format"="html"}, requirements={"_format"="html|json|xml"}))
     * @Template()
     */
    public function viewAction($id, Request $request)
    {
        $doiRepository = $this->getDoctrine()->getRepository("ILLDataCiteDOIBundle:DOI");
        $doi = $doiRepository->findOneById($id);

        if (false == $doi) {
            throw $this->createNotFoundException(sprintf("Couldn't find the DOI with the id of %s", $id));
        }

        $metadataManager = $this->container->get("ill_data_cite_doi.metadata_manager");
        $metadata = $metadataManager->find($doi->getDOI());

        if ("json" === $request->getRequestFormat()) {
            // serialize metadata object into JSON
            $serializer = new Serializer(array(new GetSetMethodNormalizer()), array(new JsonEncoder()));

            return new Response($serializer->serialize($metadata, 'json'));
        } elseif ("xml" === $request->getRequestFormat()) {
            // serialize metadata object back into XML
            $metadataSerializer = $this->container->get("ill_data_cite_doi.metadata_serializer");

            return new Response($metadataSerializer->serialize($metadata));
        }

        return array("metadata"=>$metadata, "doi"=>$doi);
    }
}
