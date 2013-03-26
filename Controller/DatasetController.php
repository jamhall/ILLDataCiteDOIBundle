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

class DatasetController extends Controller
{
    /**
     * @Route("/datasets")
     * @Template()
     */
    public function indexAction()
    {
        $doiRepository = $this->getDoctrine()->getRepository("ILLDataCiteDOIBundle:DOI");

        return array("dois"=>$doiRepository->findBy(array(), array("created"=>"DESC")));
    }

    /**
     * @Route("/datasets/{id}",requirements={ "id" : "\d+"})
     * @Template()
     */
    public function viewAction($id)
    {
        $doiRepository = $this->getDoctrine()->getRepository("ILLDataCiteDOIBundle:DOI");
        $doi = $doiRepository->findOneById($id);

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
