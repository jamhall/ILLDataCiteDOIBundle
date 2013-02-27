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
use \Versionable\Prospect\Parameter\Parameter;
use ILL\DataCiteDOIBundle\Http\Response;
use ILL\DataCiteDOIBundle\Model\DOI;

/**
 * @author Jamie Hall <hall@ill.eu>
 */
class DOIManager extends AbstractManager implements DOIManagerInterface
{
    public function find($id)
    {
        // expected response codes
        $codes = array("200"=>"OK",
                       "204"=>"No content",
                       "401"=>"Unauthorized",
                       "403"=>"Login problem or dataset belongs to another party",
                       "404"=>"Not found",
                       "410"=>"Requested dataset was marked inactive (using DELETE method)",
                       "500"=>"500 Internal Server Error");
        try {
            $request = new Request(new Url($this->adapter->getDoiGetUri($id)));
            $client = new Client($this->adapter->getAdapter());
            $response = $client->send($request, new Response());
            // check the response is valid
            if (array_key_exists($response->getCode(), $codes)) {
                // we have a successful response
                if (200 == $response->getCode()) {
                    $this->logger->info(sprintf("The DOI with the identifier of %s was retrieved", $id));
                    $doi = new DOI();
                    $doi->setIdentifier($id)
                        ->setUrl($response->getContent());

                    return $doi;
                } else {
                    $this->logger->err(sprintf("The DOI with the identifier of %s could not be retrieved. Server returned response code: %s %s", $id, $response->getCode(), $codes[$response->getCode()]));
                }
            } else {
                $this->logger->err(sprintf("Unexpected response code of %s with content of '%s' for the requested identifier of %s", $response->getCode(), $response->getContent(), $id));
            }

            return null;

        } catch (\Exception $e) {
            $this->logger->err($e->getMessage());

            return null;
        }
    }

    public function create(DOI $doi)
    {
        $request = new Request(new Url($this->adapter->getDoiPostUri()));
        $request->setMethod("POST");
        $parameters = $request->getParameters();
        $parameters->add(new Parameter('doi', $doi->getIdentifier()));
        $parameters->add(new Parameter('url', $doi->getUrl()));
        $client = new Client($this->adapter->getAdapter());
        $response = $client->send($request, new Response());
        try {
            // check the response is valid
            if ($response->isValid()) {
                $this->logger->info(sprintf("The DOI with the identifier of %s and URL of %s was created successfully.", $doi->getIdentifier(), $doi->getUrl()));

                return $doi;
            }
        } catch (\Exception $e) {
            $this->logger->err(sprintf("The DOI with the identifier of %s and URL of %s could not be created: %s.", $doi->getIdentifier(), $doi->getUrl(), $e->getMessage()));

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
