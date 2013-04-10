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

use ILL\DataCiteDOIBundle\Model\Metadata;
use ILL\DataCiteDOIBundle\Model\Metadata\AlternateIdentifier;
use ILL\DataCiteDOIBundle\Model\Metadata\Creator;
use ILL\DataCiteDOIBundle\Model\Metadata\Contributor;
use ILL\DataCiteDOIBundle\Model\Metadata\Date;
use ILL\DataCiteDOIBundle\Model\Metadata\Description;
use ILL\DataCiteDOIBundle\Model\Metadata\Format;
use ILL\DataCiteDOIBundle\Model\Metadata\RelatedIdentifier;
use ILL\DataCiteDOIBundle\Model\Metadata\ResourceType;
use ILL\DataCiteDOIBundle\Model\Metadata\Size;
use ILL\DataCiteDOIBundle\Model\Metadata\Subject;
use ILL\DataCiteDOIBundle\Model\Metadata\Title;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;
use ILL\DataCiteDOIBundle\Validator\Constraints as DataCiteAssert;

/**
 * This class represents a metadata data structure. It conforms to the metadata schema which can
 * be found here: http://schema.datacite.org/meta/kernel-2.1/metadata.xsd
 * Please also read the documentation for the metadata schema found here:
 * http://schema.datacite.org/meta/kernel-2.2/index.html
 * @author Mr. Jamie Hall <hall@ill.eu>
 */
class Metadata
{
    /**
     * A persistent identifier that identifies a resource.
     *
     * @Type("string")
     * @Assert\NotNull()
     * @Assert\NotBlank()
     */
    private $identifier;

    /**
     * Register a new DOI (or primary identifier) when the version of the resource changes to enable the citation
     * of the exact version of a research dataset (or other resource).
     * May be used in conjunction with properties 11 and 12 (AlternateIdentifier and RelatedIdentifier)
     * to indicate various information updates.
     *
     * @Type("string")
     */
    private $version;

    /**
     * Any rights information for this resource. Provide a rights management statement for the resource
     * or reference a service providing such information. Include embargo information if applicable.
     *
     * @Type("string")
     */
    private $rights;

    /**
     * A holder of the data (including archives as appropriate) or institution which submitted the work.
     * Any others may be listed as contributors.
     * This property will be used to formulate the citation, so consider the prominence of the role.
     *
     * @Type("string")
     * @Assert\NotNull()
     * @Assert\NotBlank()
     */
    private $publisher;

    /**
     * Year when the data is made publicly available. If an embargo period has been in effect, use the date when the embargo period ends.
     * @var string
     * @SerializedName("publicationYear")
     * @Type("string")
     * @Assert\NotNull()
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="/^\d{4}$/",
     *     match=true,
     *     message="Not a valid year"
     * )
     */
    private $publicationYear;

    /**
     * Primary language of the resource. Allowed values from: ISO 639-2/B, ISO 639-3
     *
     * @Type("string")
     */
    private $language;

    /**
     * The general type of the resource from a controlled list.
     * @SerializedName("resourceType")
     * @Assert\Valid()
     * @Type("ILL\DataCiteDOIBundle\Model\Metadata\ResourceType")
     */
    private $resourceType;

    /**
     * A name or title by which a resource is known.
     *
     * @Type("array<ILL\DataCiteDOIBundle\Model\Metadata\Title>")
     * @Assert\Valid()
     * @Assert\Count(
     *      min = "1",
     *      minMessage = "Must specify at least one title"
     * )
     */
    private $titles = array();

    /**
     * The main researchers involved working on the data, or the authors of the publication in priority order.
     * May be a corporate/institutional or personal name.
     *
     * @Assert\Valid()
     * @Type("array<ILL\DataCiteDOIBundle\Model\Metadata\Creator>")
     * @Assert\Count(
     *      min = "1",
     *      minMessage = "Must specify at least one creator"
     * )
     */
    private $creators = array();

    /**
     * The institution or person responsible for collecting, creating, or otherwise contributing to the development of the dataset.
     *
     * @Type("array<ILL\DataCiteDOIBundle\Model\Metadata\Contributor>")
     * @Assert\Valid()
     */
    private $contributors = array();

    /**
     * Subject, keywords, classification codes, or key phrases describing the resource.
     * @Type("array<ILL\DataCiteDOIBundle\Model\Metadata\Subject>")
     * @Assert\Valid()
     */
    private $subjects = array();

    /**
     * Different dates relevant to the work.
     *
     * @Type("array<ILL\DataCiteDOIBundle\Model\Metadata\Date>")
     * @Assert\Valid()
     */
    private $dates = array();

    /**
     * An identifier other than the primary identifier applied to the resource being registered.
     * This may be any alphanumeric string which is unique within its domain of issue. The format is open
     *
     * @SerializedName("alternateIdentifiers")
     * @Type("array<ILL\DataCiteDOIBundle\Model\Metadata\AlternateIdentifier>")
     * @Assert\Valid()
     */
    private $alternateIdentifiers = array();

    /**
     * Identifiers of related resources. Use this property to indicate subsets of properties, as appropriate.
     * @SerializedName("relatedIdentifiers")
     * @Type("array<ILL\DataCiteDOIBundle\Model\Metadata\RelatedIdentifier>")
     * @Assert\Valid()
     */
    private $relatedIdentifiers = array();

    /**
     * Unstructures size information about the resource.
     *
     * @Type("array<ILL\DataCiteDOIBundle\Model\Metadata\Size>")
     * @Assert\Valid()
     */
    private $sizes = array();

    /**
     * Technical format of the resource. Use file extension or MIME type where possible.
     *
     * @Type("array<ILL\DataCiteDOIBundle\Model\Metadata\Format>")
     * @Assert\Valid()
     */
    private $formats = array();

    /**
     * Descriptions of the resource
     *
     * @Type("array<ILL\DataCiteDOIBundle\Model\Metadata\Description>")
     * @Assert\Valid()
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
        $this->identifier = $identifier;

        return $this;
    }

    public function getIdentifier()
    {
        return $this->identifier;
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
        $this->publisher = $publisher;

        return $this;
    }

    public function getPublisher()
    {
        return $this->publisher;
    }

    public function setPublicationYear($publicationYear)
    {
        $this->publicationYear = $publicationYear;

        return $this;
    }

    public function getPublicationYear()
    {
        return $this->publicationYear;
    }

    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function setResourceType(ResourceType $resourceType)
    {
        $this->resourceType = $resourceType;

        return $this;
    }

    public function getResourceType()
    {
        return $this->resourceType;
    }

    public function addTitle(Title $title)
    {
        $this->titles[] = $title;

        return $this;
    }

    public function getTitles()
    {
        return $this->titles;
    }

    public function addCreator(Creator $creator)
    {
        $this->creators[] = $creator;

        return $this;
    }

    public function getCreators()
    {
        return $this->creators;
    }

    public function addContributor(Contributor $contributor)
    {
        $this->contributors[] = $contributor;

        return $this;
    }

    public function getContributors()
    {
        return $this->contributors;
    }

    public function addSubject(Subject $subject)
    {
        $this->subjects[] = $subject;

        return $this;
    }

    public function getSubjects()
    {
        return $this->subjects;
    }

    public function addDate(Date $date)
    {
        $this->dates[] = $date;

        return $this;
    }

    public function getDates()
    {
        return $this->dates;
    }

    public function addAlternateIdentifier(AlternateIdentifier $alternateIdentifier)
    {
        $this->alternateIdentifiers[] = $alternateIdentifier;

        return $this;
    }

    public function getAlternateIdentifiers()
    {
        return $this->alternateIdentifiers;
    }

    public function addRelatedIdentifier(RelatedIdentifier $relatedIdentifier)
    {
        $this->relatedIdentifiers[] = $relatedIdentifier;

        return $this;
    }

    public function getRelatedIdentifiers()
    {
        return $this->relatedIdentifiers;
    }

    public function addSize(Size $size)
    {
        $this->sizes[] = $size;

        return $this;
    }

    public function getSizes()
    {
        return $this->sizes;
    }

    public function addFormat(Format $format)
    {
        $this->formats[] = $format;

        return $this;
    }

    public function getFormats()
    {
        return $this->formats;
    }

    public function addDescription(Description $description)
    {
        $this->descriptions[] = $description;

        return $this;
    }

    public function getDescriptions()
    {
        return $this->descriptions;
    }
}
