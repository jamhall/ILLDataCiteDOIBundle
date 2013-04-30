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
use \Versionable\Prospect\Response\Response;
use \Versionable\Prospect\Url\Url;
use \Versionable\Prospect\Client\Client;
use \Versionable\Prospect\Parameter\Parameter;
use ILL\DataCiteDOIBundle\Model\DOI;
use Versionable\Prospect\Header\ContentType;

/**
 * @author Jamie Hall <hall@ill.eu>
 */
class DOIManager extends AbstractManager implements DOIManagerInterface
{
    public function find($id)
    {
        // expected response codes
        $codes = $this->getResponseCodes("ill.datacitedoibundle.api.doi.get");
        try {
            $request = new Request(new Url($this->adapter->getDoiGetUri($id)));
            $client = new Client($this->adapter->getAdapter());
            $response = $client->send($request, new Response());
            // check the response is valid
            if (array_key_exists($response->getCode(), $codes)) {
                // we have a successful response
                if (200 == $response->getCode()) {
                    $this->logger->info(sprintf("The DOI with the identifier of %s was retrieved", $id),
                                        array("response"=>array("code"=>sprintf("%s: %s", $response->getCode(),$codes[$response->getCode()]))));
                    $pattern = '/^(\d+\.\d+)\/(.*)/';
                    preg_match($pattern, $id, $matches);
                    $doi = new DOI();
                    $doi->setPrefix($matches[1])
                        ->setSuffix($matches[2])
                        ->setUrl($response->getContent());

                    return $doi;
                } else {
                    $this->logger->err(sprintf("The DOI with the identifier of %s could not be retrieved", $id),
                                        array("response"=>array("code"=>sprintf("%s: %s", $response->getCode(),$codes[$response->getCode()]))));
                }
            } else {
                $this->logger->err(sprintf("Unexpected response code for the retrieval of the identifier %s", $id),
                                            array("response"=>array("code"=>sprintf("%s: %s", $response->getCode(),$response::$valid_codes[$response->getCode()]))));

            }
        } catch (\Exception $e) {
            $this->logger->err($e->getMessage());
        }

        return null;
    }

    public function create(DOI $doi)
    {
        // expected response codes
        $codes = $this->getResponseCodes("ill.datacitedoibundle.api.doi.post");
        try {
            $request = new Request(new Url($this->adapter->getDoiPostUri()));
            $request->setMethod("POST");
            $request->setBody(sprintf("doi=%s\nurl=%s", $doi->getIdentifier(), $doi->getUrl()));
            $headers = $request->getHeaders();
            $headers->add(new ContentType('text/plain;charset=UTF-8'));
            $client = new Client($this->adapter->getAdapter());
            $response = $client->send($request, new Response());
            // check the response is valid
            if (array_key_exists($response->getCode(), $codes)) {
                // we have a successful response
                if (201 == $response->getCode()) {
                    $this->logger->info(sprintf("The DOI with the identifier of %s was created", $doi->getIdentifier()),
                                        array("response"=>array("code"=>sprintf("%s: %s", $response->getCode(),$codes[$response->getCode()]))));

                    return $response;
                } else {
                    $this->logger->err(sprintf("The DOI with the identifier of %s could not be created", $doi->getIdentifier()),
                                        array("response"=>array("code"=>sprintf("%s: %s", $response->getCode(),$codes[$response->getCode()]))));

                    return $response;
                }
            } else {
                $this->logger->err(sprintf("Unexpected response code for the retrieval of the identifier %s", $doi->getIdentifier()),
                                            array("response"=>array("code"=>sprintf("%s: %s", $response->getCode(),$response::$valid_codes[$response->getCode()]))));
            }
        } catch (\Exception $e) {
            $this->logger->err($e->getMessage());
        }

        return $response;
    }

    public function exists($id)
    {
        return $this->find($id) ? true : false;
    }

    public function update(DOI $doi)
    {
        // expected response codes
        $codes = $this->getResponseCodes("ill.datacitedoibundle.api.doi.post");
        try {
            $request = new Request(new Url($this->adapter->getDoiPostUri()));
            $request->setMethod("POST");
            $parameters = $request->getParameters();
            $parameters->add(new Parameter('doi', $doi->getIdentifier()));
            $parameters->add(new Parameter('url', $doi->getUrl()));
            $client = new Client($this->adapter->getAdapter());
            $response = $client->send($request, new Response());
            // check the response is valid
            if (array_key_exists($response->getCode(), $codes)) {
                // we have a successful response
                if (201 == $response->getCode()) {
                    $this->logger->info(sprintf("The DOI with the identifier of %s was updated with the new URL of %s", $doi->getIdentifier(), $doi->getUrl()),
                                        array("response"=>array("code"=>sprintf("%s: %s", $response->getCode(),$codes[$response->getCode()]))));

                    return true;
                } else {
                    $this->logger->err(sprintf("The DOI with the identifier of %s could not be updated", $doi->getIdentifier()),
                                        array("response"=>array("code"=>sprintf("%s: %s", $response->getCode(),$codes[$response->getCode()]))));
                }
            } else {
                $this->logger->err(sprintf("Unexpected response code for the updating of the identifier %s", $doi->getIdentifier()),
                                            array("response"=>array("code"=>sprintf("%s: %s", $response->getCode(),$response::$valid_codes[$response->getCode()]))));

            }
        } catch (\Exception $e) {
            $this->logger->err($e->getMessage());
        }

        return null;
    }
}
