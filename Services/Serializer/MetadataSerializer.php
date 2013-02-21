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
        /**
         * Add identifier
         */
        $identifierElement = $xml->createElement("identifier", $metadata->getIdentifier());
        $identifierElement->setAttribute("identifierType", "DOI");
        $root->appendChild($identifierElement);

        /**
         * Add creators
         */
        $creatorsElement = $xml->createElement('creators');
        $root->appendChild($creatorsElement);
        foreach ($metadata->getCreators() as $creator) {
            $creatorElement = $xml->createElement("creator");
            $creatorNameElement = $xml->createElement("creatorName", $creator->getName());
            $creatorsElement->appendChild($creatorElement);
            $creatorElement->appendChild($creatorNameElement);
            if ($creator->getNameIdentifiers()) {
                foreach ($creator->getNameIdentifiers() as $nameIdentifier) {
                    $nameIdentifierElement = $xml->createElement("nameIdentifier", $nameIdentifier->getIdentifier());
                    $nameIdentifierElement->setAttribute("nameIdentifierScheme", $nameIdentifier->getScheme());
                    $creatorElement->appendChild($nameIdentifierElement);
                }
            }
        }

        /**
         * Add titles
         */
        $titlesElement = $xml->createElement('titles');
        $root->appendChild($titlesElement);
        foreach ($metadata->getTitles() as $title) {
            $titleElement = $xml->createElement("title", $title->getTitle());
            if ($title->getType()) {
                $titleElement->setAttribute("titleType", $title->getType());
            }
            $titlesElement->appendChild($titleElement);
        }

        /**
         * Add publisher and publication year
         */
        $root->appendChild($xml->createElement("publisher", $metadata->getPublisher()));
        $root->appendChild($xml->createElement("publicationYear", $metadata->getPublicationYear()));

        /**
         * Add subjects (if any)
         */
        if ($metadata->getSubjects()) {
            $subjectsElement = $xml->createElement('subjects');
            $root->appendChild($subjectsElement);
            foreach ($metadata->getSubjects() as $subject) {
                $subjectElement = $xml->createElement("subject", $subject->getSubject());
                if ($subject->getScheme()) {
                    $subjectElement->setAttribute("subjectScheme", $subject->getScheme());
                }
                $subjectsElement->appendChild($subjectElement);
            }
        }

        /**
         * Add contributors (if any)
         */
        if ($metadata->getContributors()) {
            $contributorsElement = $xml->createElement('contributors');
            $root->appendChild($contributorsElement);
            foreach ($metadata->getContributors() as $contributor) {
                $contributorElement = $xml->createElement("contributor");
                $contributorElement->setAttribute("contributorType", $contributor->getType());
                $contributorNameElement = $xml->createElement("contributorName", $creator->getName());
                $contributorsElement->appendChild($contributorElement);
                $contributorElement->appendChild($contributorNameElement);
                if ($contributor->getNameIdentifiers()) {
                    foreach ($contributor->getNameIdentifiers() as $nameIdentifier) {
                        $nameIdentifierElement = $xml->createElement("nameIdentifier", $nameIdentifier->getIdentifier());
                        $nameIdentifierElement->setAttribute("nameIdentifierScheme", $nameIdentifier->getScheme());
                        $contributorElement->appendChild($nameIdentifierElement);
                    }
                }
            }
        }

        /**
         * Add dates (if any)
         */
        if ($metadata->getDates()) {
            $datesElement = $xml->createElement('dates');
            $root->appendChild($datesElement);
            foreach ($metadata->getDates() as $date) {
                $dateElement = $xml->createElement("date", $date->getDate());
                $dateElement->setAttribute("dateType", $date->getType());
                $datesElement->appendChild($dateElement);
            }
        }

        /**
         * Add resource type (if specified)
         */
        if ($metadata->getResourceType()) {
            $resourceType = $xml->createElement("resourceType", $metadata->getResourceType()->getType());
            $resourceType->setAttribute("resourceTypeGeneral", $metadata->getResourceType()->getResourceType());
            $root->appendChild($resourceType);
        }

        /**
         * Add alternate identifiers (if any)
         */
        if ($metadata->getAlternateIdentifiers()) {
            $alternateIdentifiersElement = $xml->createElement('alternateIdentifiers');
            $root->appendChild($alternateIdentifiersElement);
            foreach ($metadata->getAlternateIdentifiers() as $alternateIdentifier) {
                $alternateIdentifierElement = $xml->createElement("alternateIdentifier", $alternateIdentifier->getIdentifier());
                $alternateIdentifierElement->setAttribute("alternateIdentifierType", $alternateIdentifier->getType());
                $alternateIdentifiersElement->appendChild($alternateIdentifierElement);
            }
        }

        /**
         * Add related identifiers (if any)
         */
        if ($metadata->getRelatedIdentifiers()) {
            $relatedIdentifiersElement = $xml->createElement('relatedIdentifiers');
            $root->appendChild($relatedIdentifiersElement);
            foreach ($metadata->getRelatedIdentifiers() as $relatedIdentifier) {
                $relatedIdentifierElement = $xml->createElement("relatedIdentifier", $relatedIdentifier->getIdentifier());
                $relatedIdentifierElement->setAttribute("relatedIdentifierType", $relatedIdentifier->getRelatedIdentifierType());
                $relatedIdentifierElement->setAttribute("relationType", $relatedIdentifier->getRelationType());
                $relatedIdentifiersElement->appendChild($relatedIdentifierElement);
            }
        }

        /**
         * Add sizes (if any)
         */
        if ($metadata->getSizes()) {
            $sizesElement = $xml->createElement('sizes');
            $root->appendChild($sizesElement);
            foreach ($metadata->getSizes() as $size) {
                $sizesElement->appendChild($xml->createElement("size", $size->getSize()));
            }
        }

        /**
         * Add formats (if any)
         */
        if ($metadata->getFormats()) {
            $formatsElement = $xml->createElement('formats');
            $root->appendChild($formatsElement);
            foreach ($metadata->getFormats() as $format) {
                $formatsElement->appendChild($xml->createElement("format", $format->getFormat()));
            }
        }

        /**
         * Set version (if specified)
         */
        if ($metadata->getVersion()) {
            $root->appendChild($xml->createElement("version", $metadata->getVersion()));
        }

        /**
         * Set rights (if specified)
         */
        if ($metadata->getRights()) {
            $root->appendChild($xml->createElement("rights", $metadata->getRights()));
        }

        /**
         * Add descriptions (if any)
         */
        if ($metadata->getDescriptions()) {
            $descriptionsElement = $xml->createElement('descriptions');
            $root->appendChild($descriptionsElement);
            foreach ($metadata->getDescriptions() as $description) {
                $descriptionElement = $xml->createElement("description", $description->getDescription());
                if ($description->getType()) {
                    $descriptionElement->setAttribute("descriptionType", $description->getType());
                }
                $descriptionsElement->appendChild($descriptionElement);
            }
        }

        /**
         * Validate the XML produced against the Metadata XSD
         * @var [type]
         */
        $validate = new \DOMDocument;
        $validate->loadXML($xml->savexml());

        try {
            if ($validate->schemaValidate("/home/hall/workspace/illdatacitedoibundle/Model/Metadata/Schema/metadata.xsd")) {
                return $xml->savexml();
            }
        } catch (\ErrorException $e) {
            throw new \Exception("The XML could not be validated: " . $e->getMessage());
        }
        #file_put_contents("/tmp/test.xml", $xml->savexml());
    }

    /**
     * Unserialize XML returned from the API into a metadata model
     * @return object Metadata
     */
    public static function unserialize($xml)
    {

    }
}
