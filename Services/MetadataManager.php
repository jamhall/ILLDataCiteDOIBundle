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

use ILL\DataCiteDOIBundle\Model\Metadata;
use ILL\DataCiteDOIBundle\Model\DOI;
use \Versionable\Prospect\Request\Request;
use \Versionable\Prospect\Url\Url;
use \Versionable\Prospect\Client\Client;
use \Versionable\Prospect\Header\Custom as HeaderCustom;

use Versionable\Prospect\Header\ContentType;
use \Versionable\Prospect\Response\Response;
use ILL\DataCiteDOIBundle\Services\Serializer\MetadataSerializer;
//use Symfony\Component\Validator\Constraints as Assert;
use ILL\DataCiteDOIBundle\Validator\Constraints as DataCiteAssert;

/**
 * @author Jamie Hall <hall@ill.eu>
 */
class MetadataManager extends AbstractManager implements MetadataManagerInterface
{

    public function create(Metadata $metadata)
    {
        // expected response codes
        $codes = $this->getResponseCodes("ill.datacitedoibundle.api.metadata.post");
        try {
            $request = new Request(new Url($this->adapter->getMetadataPostUri($metadata->getIdentifier())));
            $request->setMethod("POST");
            $headers = $request->getHeaders();

            // Set the content type
            $headers->add(new ContentType('application/xml;charset=UTF-8'));

            // Disable 100-continue header
            $headers->add(new HeaderCustom("Expect"));

            // fill body with XML metadata
            $request->setBody(MetadataSerializer::serialize($metadata));
            $client = new Client($this->adapter->getAdapter());
            $response = $client->send($request, new Response());
            // check the response is valid
            if (array_key_exists($response->getCode(), $codes)) {
                // we have a successful response
                if (201 == $response->getCode()) {
                    $this->logger->info(sprintf("The metadata with the identifier of %s was created successfully", $metadata->getIdentifier()),
                                        array("response"=>array("code"=>sprintf("%s: %s", $response->getCode(),$codes[$response->getCode()]))));

                    return true;
                } else {
                    $this->logger->err(sprintf("The metadata for the identifier of %s could not be created", $metadata->getIdentifier()),
                                        array("response"=>array("code"=>sprintf("%s: %s", $response->getCode(),$codes[$response->getCode()]))));
                }
            } else {
                $this->logger->err(sprintf("Unexpected response code for the creation of the metadata the identifier of %s", $metadata->getIdentifier()),
                                            array("response"=>array("code"=>sprintf("%s: %s", $response->getCode(),$response::$valid_codes[$response->getCode()]))));

            }
        } catch (\Exception $e) {
            $this->logger->err($e->getMessage());
        }

        return null;
    }

    public function update(Metadata $metadata)
    {
        // expected response codes
        $codes = $this->getResponseCodes("ill.datacitedoibundle.api.metadata.post");
        try {
            $request = new Request(new Url($this->adapter->getMetadataPostUri($metadata->getIdentifier())));
            $request->setMethod("POST");
            $headers = $request->getHeaders();

            // Set the content type
            $headers->add(new ContentType('application/xml;charset=UTF-8'));

            // Disable 100-continue header
            $headers->add(new HeaderCustom("Expect"));

            // fill body with XML metadata
            $request->setBody(MetadataSerializer::serialize($metadata));
            $client = new Client($this->adapter->getAdapter());
            $response = $client->send($request, new Response());
            // check the response is valid
            if (array_key_exists($response->getCode(), $codes)) {
                // we have a successful response
                if (201 == $response->getCode()) {
                    $this->logger->info(sprintf("The metadata with the identifier of %s was updated successfully", $metadata->getIdentifier()),
                                        array("response"=>array("code"=>sprintf("%s: %s", $response->getCode(),$codes[$response->getCode()]))));

                    return true;
                } else {
                    $this->logger->err(sprintf("The metadata for the identifier of %s could not be updated", $metadata->getIdentifier()),
                                        array("response"=>array("code"=>sprintf("%s: %s", $response->getCode(),$codes[$response->getCode()]))));
                }
            } else {
                $this->logger->err(sprintf("Unexpected response code for the updation of the metadata the identifier of %s", $metadata->getIdentifier()),
                                            array("response"=>array("code"=>sprintf("%s: %s", $response->getCode(),$response::$valid_codes[$response->getCode()]))));

            }
        } catch (\Exception $e) {
            $this->logger->err($e->getMessage());
        }

        return null;
    }

    public function find($id)
    {
        // expected response codes
        $codes = $this->getResponseCodes("ill.datacitedoibundle.api.metadata.get");
        try {
            $request = new Request(new Url($this->adapter->getMetadataGetDeleteUri($id)));
            $client = new Client($this->adapter->getAdapter());
            $response = $client->send($request, new Response());
            // check the response is valid
            if (array_key_exists($response->getCode(), $codes)) {
                // we have a successful response
                if (200 == $response->getCode()) {
                    $this->logger->info(sprintf("The metadata with the identifier of %s was retrieved", $id),
                                        array("response"=>array("code"=>sprintf("%s: %s", $response->getCode(),$codes[$response->getCode()]))));

                    return MetadataSerializer::unserialize($response->getContent());
                } else {
                    $this->logger->err(sprintf("The metadata with the identifier of %s could not be retrieved", $id),
                                        array("response"=>array("code"=>sprintf("%s: %s", $response->getCode(),$codes[$response->getCode()]))));
                }
            } else {
                $this->logger->err(sprintf("Unexpected response code for the retrieval of the metadata for the identifier of %s", $id),
                                            array("response"=>array("code"=>sprintf("%s: %s", $response->getCode(),$response::$valid_codes[$response->getCode()]))));

            }
        } catch (\Exception $e) {
            $this->logger->err($e->getMessage());
        }

        return null;
    }

    public function delete(Metadata $metadata)
    {
        // expected response codes
        $codes = $this->getResponseCodes("ill.datacitedoibundle.api.metadata.delete");
        try {
            $request = new Request(new Url($this->adapter->getMetadataGetDeleteUri($metadata->getIdentifier())));
            $request->setMethod("DELETE");
            $client = new Client($this->adapter->getAdapter());
            $response = $client->send($request, new Response());
            // check the response is valid
            if (array_key_exists($response->getCode(), $codes)) {
                // we have a successful response
                if (200 == $response->getCode()) {
                    $this->logger->info(sprintf("The metadata for the DOI with the identifier of %s was deleted", $metadata->getIdentifier()),
                                        array("response"=>array("code"=>sprintf("%s: %s", $response->getCode(),$codes[$response->getCode()]))));

                    return true;
                } else {
                    $this->logger->err(sprintf("The metadata for the DOI with the identifier of %s could not be deleted", $metadata->getIdentifier()),
                                        array("response"=>array("code"=>sprintf("%s: %s", $response->getCode(),$codes[$response->getCode()]))));
                }
            } else {
                $this->logger->err(sprintf("Unexpected response code for the deletion of the metadata for DOI with the identifier of %s", $metadata->getIdentifier()),
                                            array("response"=>array("code"=>sprintf("%s: %s", $response->getCode(),$response::$valid_codes[$response->getCode()]))));

            }
        } catch (\Exception $e) {
            $this->logger->err($e->getMessage());
        }

        return null;
    }

    public function deleteById($id)
    {

    }

    public function isValid(Metadata $metadata)
    {
        $errors = $this->validator->validateValue($metadata->getIdentifier(), new DataCiteAssert\MetadataIdentifier($this->defaults['prefix']));
        if (count($errors) > 0) {
            return $errors;
        } else {
            return $this->validator->validate($metadata);
        }
    }
}
