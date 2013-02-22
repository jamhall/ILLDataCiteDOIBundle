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
use ILL\DataCiteDOIBundle\Http\Response;
use ILL\DataCiteDOIBundle\Services\Serializer\MetadataSerializer;
/**
 * @author Jamie Hall <hall@ill.eu>
 */
class MetadataManager extends AbstractManager implements MetadataManagerInterface
{
    public function create(Metadata $metadata)
    {

    }
    public function update(DOI $doi, Metadata $metadata)
    {

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
    public function delete($id)
    {

    }
}
