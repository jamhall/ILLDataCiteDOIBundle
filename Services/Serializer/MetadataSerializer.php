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
use ILL\DataCiteDOIBundle\Model\Metadata\Creator;
use ILL\DataCiteDOIBundle\Model\Metadata\Title;
use ILL\DataCiteDOIBundle\Model\Metadata\NameIdentifier;
use ILL\DataCiteDOIBundle\Model\Metadata\Subject;
use ILL\DataCiteDOIBundle\Model\Metadata\Contributor;
use ILL\DataCiteDOIBundle\Model\Metadata\Date;
use ILL\DataCiteDOIBundle\Model\Metadata\ResourceType;
use ILL\DataCiteDOIBundle\Model\Metadata\AlternateIdentifier;
use ILL\DataCiteDOIBundle\Model\Metadata\RelatedIdentifier;
use ILL\DataCiteDOIBundle\Model\Metadata\Size;
use ILL\DataCiteDOIBundle\Model\Metadata\Format;
use ILL\DataCiteDOIBundle\Model\Metadata\Description;
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
    const DATACITE_KERNEL_RESOURCE_NAMESPACE = "http://datacite.org/schema/kernel-3";
    const W3_XML_SCHEMA_NAMESPACE = "http://www.w3.org/2001/XMLSchema-instance";
    const DATACITE_METADATA_XML_SCHEMA = "http://schema.datacite.org/meta/kernel-3/metadata.xsd";

    /**
     * Serialize metadata model into XML for the API
     * @param object Metadata
     * @param String fileDirectory Location to store the XML output
     * @param String fileName Name of the file
     * @return string
     */
    public static function serialize(Metadata $metadata, $fileDirectory = null, $fileName = null)
    {
        // create a new XML document
        $xml = new \DomDocument();
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
            if ($creator->getNameIdentifier()) {
                    $nameIdentifierElement = $xml->createElement("nameIdentifier", $creator->getNameIdentifier()->getIdentifier());
                    $nameIdentifierElement->setAttribute("nameIdentifierScheme", $creator->getNameIdentifier()->getScheme());
                    $nameIdentifierElement->setAttribute("schemeURI", $creator->getNameIdentifier()->getSchemeUri());
                    $creatorElement->appendChild($nameIdentifierElement);
            }
        }

        /**
         * Add titles
         */
        $titlesElement = $xml->createElement('titles');
        $root->appendChild($titlesElement);
        foreach ($metadata->getTitles() as $title) {
            $titleElement = $xml->createElement("title");
            $titleElement->appendChild(
                $xml->createTextNode($title->getTitle()));
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
                $contributorNameElement = $xml->createElement("contributorName", $contributor->getName());
                $contributorsElement->appendChild($contributorElement);
                $contributorElement->appendChild($contributorNameElement);
                if ($contributor->getNameIdentifier()) {
                    $nameIdentifierElement = $xml->createElement("nameIdentifier", $contributor->getNameIdentifier()->getIdentifier());
                    $nameIdentifierElement->setAttribute("nameIdentifierScheme", $contributor->getNameIdentifier()->getScheme());
                    $contributorElement->appendChild($nameIdentifierElement);
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
         * Set language (if specified)
         */
        if ($metadata->getLanguage()) {
            $root->appendChild($xml->createElement("language", $metadata->getLanguage()));
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
        * This an ugly hack. The XML produced includes the XML declaration.
        * There is no way to not include this (why?!?!)
        * We have to instantiate another DomDocument so we can validate the previous document against
        * the XSD schema.
        * This seems to work but I'm not entirely happy with this solution
        */
        $validate = new \DOMDocument();
        $xmlOutput = $xml->saveXML($xml->documentElement);
        $validate->loadXML($xmlOutput);

        try {
            if ($validate->schemaValidate(__DIR__ . "../../../Model/Metadata/Schema/metadata.xsd")) {
                return $xmlOutput;
            }
        } catch (\ErrorException $e) {
            throw new \Exception("The XML could not be validated: " . $e->getMessage());
        }
    }

    /**
     * Unserialize XML returned from the API into a metadata model
     * @return object Metadata
     */
    public static function unserialize($xmlString)
    {
        $xml = simplexml_load_string($xmlString);
        $metadata = new Metadata();
        $metadata->setIdentifier((string) $xml->identifier)
                 ->setPublisher((string) $xml->publisher)
                 ->setPublicationYear((string) $xml->publicationYear);

        /**
         * Get creators
         */
        if (isset($xml->creators)) {
            foreach ($xml->creators->creator as $creatorElement) {
                $creator = new Creator();
                $creator->setName((string) $creatorElement->creatorName);
                foreach ($creatorElement->nameIdentifier as $nameIdentifierElement) {
                    $nameIdentifier = new NameIdentifier();
                    $nameIdentifier->setScheme((string) $nameIdentifierElement->attributes()->nameIdentifierScheme);
                    $nameIdentifier->setIdentifier((string) $nameIdentifierElement);
                    $creator->setNameIdentifier($nameIdentifier);
                }
                $metadata->addCreator($creator);
            }
        }

        /**
         * Get titles
         */
        if (isset($xml->titles)) {
            foreach ($xml->titles->title as $titleElement) {
                $title = new Title();
                $title->setTitle((string) $titleElement);
                // check if we have a title type
                if (isset($titleElement->attributes()->titleType)) {
                    $title->setType((string) $titleElement->attributes()->titleType);
                }
                $metadata->addTitle($title);
            }
        }

        /**
         * Get subjects
         */
        if (isset($xml->subjects)) {
            foreach ($xml->subjects->subject as $subjectElement) {
                $subject = new Subject();
                $subject->setSubject((string) $subjectElement);
                // check if we have a subject scheme
                if (isset($subjectElement->attributes()->subjectScheme)) {
                    $subject->setScheme((string) $subjectElement->attributes()->subjectScheme);
                }
                $metadata->addSubject($subject);
            }
        }

        /**
         * Get contributors
         */
        if (isset($xml->contributors)) {
            foreach ($xml->contributors->contributor as $contributorElement) {
                $contributor = new Contributor();
                $contributor->setName((string) $contributorElement->contributorName);
                $contributor->setType((string) $contributorElement->attributes()->contributorType);
                foreach ($contributorElement->nameIdentifier as $nameIdentifierElement) {
                    $nameIdentifier = new NameIdentifier();
                    $nameIdentifier->setScheme((string) $nameIdentifierElement->attributes()->nameIdentifierScheme);
                    $nameIdentifier->setIdentifier((string) $nameIdentifierElement);
                    $contributor->setNameIdentifier($nameIdentifier);
                }
                $metadata->addContributor($contributor);
            }
        }

        /**
         * Get language
         */
        if (isset($xml->language)) {
            $metadata->setLanguage((string) $xml->language);
        }

        /**
         * Get dates
         */
        if (isset($xml->dates)) {
            foreach ($xml->dates->date as $dateElement) {
                $date = new Date();
                $date->setDate((string) $dateElement);
                // check if we have a subject scheme
                if (isset($dateElement->attributes()->dateType)) {
                    $date->setType((string) $dateElement->attributes()->dateType);
                }
                $metadata->addDate($date);
            }
        }

        /**
         * Get resource type
         */
        if (isset($xml->resourceType)) {
                $resourceType = new ResourceType();
                $resourceType->setResourceType((string) $xml->resourceType->attributes()->resourceTypeGeneral);
                $resourceType->setType((string) $xml->resourceType);
                $metadata->setResourceType($resourceType);
        }

        /**
         * Get alternate identifiers
         */
        if (isset($xml->alternateIdentifiers)) {
            foreach ($xml->alternateIdentifiers->alternateIdentifier as $alternateIdentifierElement) {
                $alternateIdentifier = new AlternateIdentifier();
                $alternateIdentifier->setType((string) $alternateIdentifierElement->attributes()->alternateIdentifierType);
                $alternateIdentifier->setIdentifier((string) $alternateIdentifierElement);
                $metadata->addAlternateIdentifier($alternateIdentifier);
            }
        }
        /**
         * Get alternate identifiers
         */
        if (isset($xml->relatedIdentifiers)) {
            foreach ($xml->relatedIdentifiers->relatedIdentifier as $relatedIdentifierElement) {
                $relatedIdentifier = new RelatedIdentifier();
                $relatedIdentifier->setRelatedIdentifierType((string) $relatedIdentifierElement->attributes()->relatedIdentifierType);
                $relatedIdentifier->setRelationType((string) $relatedIdentifierElement->attributes()->relationType);
                $relatedIdentifier->setIdentifier((string) $relatedIdentifierElement);
                $metadata->addRelatedIdentifier($relatedIdentifier);
            }
        }

        /**
         * Get sizes
         */
        if (isset($xml->sizes)) {
            foreach ($xml->sizes->size as $sizeElement) {
                $metadata->addSize(new Size((string) $sizeElement));
            }
        }

        /**
         * Get formats
         */
        if (isset($xml->formats)) {
            foreach ($xml->formats->format as $formatElement) {
                $metadata->addFormat(new Format((string) $formatElement));
            }
        }

        /**
         * Get rights
         */
        if (isset($xml->rights)) {
            $metadata->setRights((string) $xml->rights);
        }

        /**
         * Get version
         */
        if (isset($xml->version)) {
            $metadata->setVersion((string) $xml->version);
        }

        /**
         * Get descriptions
         */
        if (isset($xml->descriptions)) {
            foreach ($xml->descriptions->description as $descriptionElement) {
                $description = new Description();
                $description->setDescription(trim((string) $descriptionElement));
                $description->setType((string) $descriptionElement->attributes()->descriptionType);
                $metadata->addDescription($description);
            }
        }

       return $metadata;
    }
}
