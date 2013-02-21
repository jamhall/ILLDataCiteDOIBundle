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
     * XML namespaces and XML schemas
     */
    const W3_XML_NAMESPACE = "http://www.w3.org/2000/xmlns/";
    const DATACITE_KERNEL_RESOURCE_NAMESPACE = "http://datacite.org/schema/kernel-2.1";
    const W3_XML_SCHEMA_NAMESPACE = "http://www.w3.org/2001/XMLSchema-instance";
    const DATACITE_METADATA_XML_SCHEMA = "http://schema.datacite.org/meta/kernel-2.1/metadata.xsd";

    /**
     * Serialize metadata model into XML for the API
     * @return string
     */
    public static function serialize(Metadata $metadata)
    {
        // create a new XML document
        $xml = new \DomDocument('1.0', 'UTF-8');
        // create root node
        $root = $xml->createElementNS(self::DATACITE_KERNEL_RESOURCE_NAMESPACE, 'resource');
        $root = $xml->appendChild($root);
        $root->setAttributeNS(self::W3_XML_NAMESPACE ,'xmlns:xsi', self::W3_XML_SCHEMA_NAMESPACE);
        $root->setAttributeNS(self::W3_XML_SCHEMA_NAMESPACE, 'schemaLocation', sprintf("%s %s",
                                                                                       self::DATACITE_KERNEL_RESOURCE_NAMESPACE,
                                                                                       self::DATACITE_METADATA_XML_SCHEMA));


    }

    /**
     * Unserialize XML returned from the API into a metadata model
     * @return object Metadata
     */
    public static function unserialize($xml)
    {

    }
}
