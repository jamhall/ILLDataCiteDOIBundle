<?php
/*
* This file is part of the ILLDataCiteDOIBundle package.
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*
* @License  MIT License
*/

namespace ILL\DataCiteDOIBundle\Services;

use \Versionable\Prospect\Request\Request;
use \Versionable\Prospect\Url\Url;
use \Versionable\Prospect\Client\Client;
use \Versionable\Prospect\Header\Collection;
use \Versionable\Prospect\Parameter\Parameter;
use ILL\DataCiteDOIBundle\Http\Response;
use ILL\DataCiteDOIBundle\Model\DOI;
use ILL\DataCiteDOIBundle\Model\Metadata;
use Symfony\Component\Validator\Validator;

/**
 * @author Jamie Hall <hall@ill.eu>
 */
class DOIManager extends AbstractManager implements DOIManagerInterface
{
    private $doi = null;

    public function find($id)
    {
        $request = new Request(new Url($this->adapter->getDoiGetUri($id)));
        $client = new Client($this->adapter->getAdapter());
        $response = $client->send($request, new Response());
        try {
            // check the response is valid
            if ($response->isValid()) {
                $this->doi = new DOI();
                $this->doi->setIdentifier($id)
                          ->setUrl($response->getContent());

                return $this->doi;
            }
        } catch (\Exception $e) {
            return null;
        }
    }

    public function create(DOI $doi)
    {
        $errors = $this->validator->validate($doi);
        $request = new Request(new Url($this->adapter->getDoiPostUri()));
        $request->setMethod("POST");
        $parameters = $request->getParameters();
        $parameters->add(new Parameter('doi', $doi->getIdentifier()));
        $parameters->add(new Parameter('url', $doi->getUrl()));
        //$request->setParameters($parameters);
        $client = new Client($this->adapter->getAdapter());
        $response = $client->send($request, new Response());
        try {
            // check the response is valid
            if ($response->isValid()) {

                return $doi;
            }
        } catch (\Exception $e) {

            return null;
        }
    }

    public function exists($id)
    {

    }

    public function update(DOI $doi)
    {

    }
}
