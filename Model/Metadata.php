<?php
/*
* This file is part of the ILLDataCiteDOIBundle package.
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*
* @License  MIT License
*/

namespace ILL\DataCiteDOIBundle\Model;
/**
 * This class represents a metadata data structure. It conforms to the metadata xsd file which can
 * be found here: http://schema.datacite.org/meta/kernel-2.1/metadata.xsd
 * @author Jamie Hall <hall@ill.eu>
 */
class Metadata
{
    /**
     * A persistent identifier that identifies a resource.
     * @var string
     */
    private $identifier;
    /**
     * Register a new DOI (or primary identifier) when the version of the resource changes to enable the citation
     * of the exact version of a research dataset (or other resource).
     * May be used in conjunction with properties 11 and 12 (AlternateIdentifier and RelatedIdentifier)
     * to indicate various information updates.
     * @var string
     */
    private $version;

    /**
     * Any rights information for this resource. Provide a rights management statement for the resource
     * or reference a service providing such information. Include embargo information if applicable.
     * @var string
     */
    private $rights;

    /**
     * A holder of the data (including archives as appropriate) or institution which submitted the work.
     * Any others may be listed as contributors.
     * This property will be used to formulate the citation, so consider the prominence of the role.
     * @var string
     */
    private $publisher;

    /**
     * Year when the data is made publicly available. If an embargo period has been in effect, use the date when the embargo period ends.
     * @var string
     */
    private $publicationYear;

    /**
     * Primary language of the resource. Allowed values from: ISO 639-2/B, ISO 639-3
     * @var string
     */
    private $language;

    /**
     * The general type of the resource from a controlled list.
     * @var string
     */
    private $resourceType;

    /**
     * A name or title by which a resource is known.
     * @var array
     */
    private $titles = array();

    /**
     * The main researchers involved working on the data, or the authors of the publication in priority order.
     * May be a corporate/institutional or personal name.
     * @var array
     */
    private $creators = array();

    /**
     * The institution or person responsible for collecting, creating, or otherwise contributing to the developement of the dataset.
     * @var array
     */
    private $contributors = array();

    /**
     * Subject, keywords, classification codes, or key phrases describing the resource.
     * @var array
     */
    private $subjects = array();

    /**
     * Different dates relevant to the work.
     * @var array
     */
    private $dates = array();

    /**
     * An identifier other than the primary identifier applied to the resource being registered.
     * This may be any alphanumeric string which is unique within its domain of issue. The format is open
     * @var array
     */
    private $alternateIdentifiers = array();

    /**
     * Identifiers of related resources. Use this property to indicate subsets of properties, as appropriate.
     * @var array
     */
    private $relatedIdentifiers = array();

    /**
     * Unstructures size information about the resource.
     * @var array
     */
    private $sizes = array();

    /**
     * Technical format of the resource. Use file extension or MIME type where possible.
     * @var array
     */
    private $formats = array();

    /**
     * Descriptions of the resource
     * @var array
     */
    private $descriptions = array();

    public function __construct($identifier = null)
    {
        if (null !== $identifier) {
            $this->setIdentifier($identifier);
        }
    }

    public function setIdentifier($identifier)
    {
        // check if a valid year
        if (true === preg_match("[1][0][/.].*" , $identifier)) {
            $this->identifier = $identifier;

            return $this;
        }
        throw new \InvalidArgumentException("Not a valid identifier. DOI must start with '10.'");
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function setLanguage($language)
    {
        if (3 !== strlen($language)) {
            throw new \InvalidArgumentException("The language must be a three letter code");
        }
        $this->language = $language;

        return $this;
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function setRights($rights)
    {
        $this->rights = $rights;

        return $this;
    }

    public function getRights()
    {
        return $this->rights;
    }

    public function setPublisher($publisher)
    {
        if (null === $publisher) {
            throw new \InvalidArgumentException("The publisher cannot be null");
        }
        $this->publisher = $publisher;

        return $this;
    }

    public function getPublisher()
    {
        return $this->publisher;
    }

    public function setPublicationYear($publicationYear)
    {
        // check if a valid year
        if (true === preg_match("^\d{4}$" , $publicationYear)) {
            $this->publicationYear = $publicationYear;

            return $this;
        }
        throw new \InvalidArgumentException("Not a valid year. It must be of the format: YYYY");
    }

    public function getPublicationYear()
    {
        return $this->publicationYear;
    }

}
