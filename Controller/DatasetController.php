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
        $dois->setMaxPerPage(2);

        try {
            $dois->setCurrentPage($page);
        } catch (NotValidCurrentPageException $e) {
            throw $this->createNotFoundException("Page not found");
        }

        return array("dois"=>$dois);
    }

    /**
     * @Route("/datasets/{id}",requirements={ "id" : "\d+"})
     * @Template()
     */
    public function viewAction($id)
    {
        $doiRepo = $this->container->get("ill_data_cite_doi.doctrine.repository.doi");
        $doi = $doiRepo->findOneById($id);

        if (false == $doi) {
            throw $this->createNotFoundException(sprintf("Couldn't find the DOI with the id of %s", $id));
        }

        $metadataManager = $this->container->get("ill_data_cite_doi.metadata_manager");
        $metadata = $metadataManager->find($doi->getDOI());

        return array("doi"=>$doi, "metadata"=>$metadata);
    }

    /**
     * @Route("/datasets/register")
     * @Template()
     */
    public function registerAction()
    {
        $doiRepository = $this->getDoctrine()->getRepository("ILLDataCiteDOIBundle:DOI");

        return array("dois"=>$doiRepository->findBy(array(), array("created"=>"DESC")));
    }

}
