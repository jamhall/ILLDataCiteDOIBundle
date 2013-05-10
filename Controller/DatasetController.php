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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Pagerfanta\Exception\NotValidCurrentPageException;

class DatasetController extends Controller
{
    /**
     * @Route("/datasets")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $doiRepo = $this->container->get("ill_data_cite_doi.doctrine.repository.doi");
        $dois = $doiRepo->findAll(true);
        $page = ($request->query->has('page')) ? $request->query->get('page') : 1;
        $dois->setMaxPerPage(50);

        try {
            $dois->setCurrentPage($page);
        } catch (NotValidCurrentPageException $e) {
            throw $this->createNotFoundException("Page not found");
        }

        return array("dois"=>$dois);
    }

    /**
     * @Route("/datasets/{id}",requirements={"id" : "\d+"})
     * @Template()
     */
    public function viewAction($id)
    {
        $doiRepo = $this->container->get("ill_data_cite_doi.doctrine.repository.doi");
        $doi = $doiRepo->findOneById($id);
        $dm = $this->container->get("ill_data_cite_doi.manager");
        if (false == $doi) {
            throw $this->createNotFoundException(sprintf("Couldn't find the DOI with the id of %s", $id));
        }

        return array("doi"=>$doi, "url"=>$dm->find($doi->getIdentifier())->getUrl());
    }

    /**
     * @Route("/datasets/register")
     * @Template()
     */
    public function createAction(Request $request)
    {
        // ajax request
        if ($request->isXmlHttpRequest()) {
            if($request->isMethod('POST')) {
                $serializer = \JMS\Serializer\SerializerBuilder::create()->setDebug(false)->build();
                $metadata = $serializer->deserialize($request->getContent(), 'ILL\DataCiteDOIBundle\Model\Metadata', 'json');
                $metadataManager = $this->container->get("ill_data_cite_doi.metadata_manager");
                $errors = $metadataManager->isValid($metadata);
                if(count($errors) > 0) {
                    // invalid metadata
                    var_dump($errors); die();
                    return new JsonResponse(array("success"=>"false", "message"=>"The metadata submitted is invalid"));
                } else {
                    // valid, upload to datacite
                    //if($metadataManager->create($metadata)) {
                        return new JsonResponse(array("success"=>"true", "message"=>"The metadata was uploaded to datacite"));
                    //}
                    $response = new Response($serializer->serialize($metadata, 'json'));
                    $response->headers->set('Content-Type', 'application/json');
                    return $response;
                }
            } else {
                throw new HttpException(400, "Invalid request");
            }
        }
        return array();
    }

}
