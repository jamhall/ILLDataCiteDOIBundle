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
use ILL\DataCiteDOIBundle\Http\Response;
use ILL\DataCiteDOIBundle\Services\Serializer\MetadataSerializer;
/**
 * @author Jamie Hall <hall@ill.eu>
 */
class MetadataManager extends AbstractManager implements MetadataManagerInterface
{
    private function createUpdate(Metadata $metadata)
    {
        // @TODO check metadata is valid
        $request = new Request(new Url($this->adapter->getMetadataPostUri()));
        $headers = $request->getHeaders();

        // Set the content type (use latest version)
        $headers->add(new ContentType('application/xml;charset=UTF-8'));

        // Disable 100-continue header
        $headers->add(new HeaderCustom("Expect"));

        // fill body with XML metadata
        $request->setBody(MetadataSerializer::serialize($metadata));

        $request->setMethod("POST");
        $client = new Client($this->adapter->getAdapter());
        $response = $client->send($request, new Response());

        try {
            // check the response is valid
            if ($response->isValid()) {
                return true;
            }
        } catch (\Exception $e) {
            #throw new \Exception($e->getMessage());

            return false;
        }
    }

    public function create(Metadata $metadata)
    {
        return $this->createUpdate($metadata);
    }

    public function update(DOI $doi, Metadata $metadata)
    {
        return $this->createUpdate($metadata);
    }

    public function find($id)
    {
        $request = new Request(new Url($this->adapter->getMetadataGetDeleteUri($id)));
        $client = new Client($this->adapter->getAdapter());
        $response = $client->send($request, new Response());
        $request->setMethod("GET");
        try {
            // check the response is valid
            if ($response->isValid()) {
                return MetadataSerializer::unserialize($response->getContent());
            }
        } catch (\Exception $e) {
            return null;
        }
    }

    public function exists($id)
    {

    }

    public function delete(Metadata $metadata)
    {
        $request = new Request(new Url($this->adapter->getMetadataGetDeleteUri($metadata->getIdentifier())));
        $request->setMethod("DELETE");
        $client = new Client($this->adapter->getAdapter());
        $response = $client->send($request, new Response());
        try {
            // check the response is valid
            if ($response->isValid()) {
                return true;
            }
        } catch (\Exception $e) {
            return null;
        }
    }

    public function deleteById($id)
    {

    }
}
