<?php
/*
* This file is part of the ILLDataCiteDOIBundle package.
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*
* @License  MIT License
*/

namespace ILL\DataCiteDOIBundle\Services\Serializer;

use ILL\DataCiteDOIBundle\Model\Metadata;

/**
 * Serialization and unserialization of metadata
 * @author Jamie Hall <hall@ill.eu>
 */
class MetadataSerializer
{
    /**
     * Serialize metadata model into XML for the API
     * @return string
     */
    public function serialize(Metadata $metadata)
    {

    }

    /**
     * Unserialize XML returned from the API into a metadata model
     * @return object Metadata
     */
    public function unserialize($xml)
    {

    }
}
