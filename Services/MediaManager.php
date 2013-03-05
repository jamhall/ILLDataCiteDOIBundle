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
use ILL\DataCiteDOIBundle\Model\Media;
use \Versionable\Prospect\Request\Request;
use \Versionable\Prospect\Url\Url;
use \Versionable\Prospect\Client\Client;
use \Versionable\Prospect\Header\Custom as HeaderCustom;
use Versionable\Prospect\Header\ContentType;
use \Versionable\Prospect\Response\Response;
/**
 * @author Jamie Hall <hall@ill.eu>
 */
class MediaManager extends AbstractManager
{

    public function create(DOI $doi, Media $media)
    {
        // expected response codes
        $codes = $this->getResponseCodes("ill.datacitedoibundle.api.media.post");
        try {
            $request = new Request(new Url($this->adapter->getMediaGetPostUri($doi->getIdentifier())));
            $request->setMethod("POST");
            $headers = $request->getHeaders();

            // Set the content type (use latest version)
            $headers->add(new ContentType('text/plain;charset=UTF-8'));

            // Disable 100-continue header
            $headers->add(new HeaderCustom("Expect"));
            $request->setBody(sprintf("%s=%s", $media->getMimeType(), $media->getUrl()));
            $client = new Client($this->adapter->getAdapter());
            $response = $client->send($request, new Response());
            // check the response is valid
            if (array_key_exists($response->getCode(), $codes)) {
                // we have a successful response
                if (200 == $response->getCode()) {
                    $this->logger->info(sprintf("The media for the DOI of %s was created successfully", $doi->getIdentifier()),
                                        array("parameters"=>array("mime-type"=>$media->getMimeType(), "url"=>$media->getUrl()),
                                              "response"=>array("code"=>sprintf("%s: %s", $response->getCode(),$codes[$response->getCode()]))));

                    return true;
                } else {
                    $this->logger->err(sprintf("The media for the DOI of %s could not be created", $doi->getIdentifier()),
                                        array("parameters"=>array("mime-type"=>$media->getMimeType(), "url"=>$media->getUrl()),
                                              "response"=>array("code"=>sprintf("%s: %s", $response->getCode(),$codes[$response->getCode()]))));
                }
            } else {
                    $this->logger->err(sprintf("Unexpected response code for the creation of media for the DOI of %s", $doi->getIdentifier()),
                                        array("parameters"=>array("mime-type"=>$media->getMimeType(), "url"=>$media->getUrl()),
                                              "response"=>array("code"=>sprintf("%s: %s", $response->getCode(),$codes[$response->getCode()]))));
            }
        } catch (\Exception $e) {
            $this->logger->err($e->getMessage());
        }

        return null;
    }
}
