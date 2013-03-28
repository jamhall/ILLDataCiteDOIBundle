<?php
/*
* This file is part of the ILLDataCiteDOIBundle package.
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*
* @License  MIT License
*/

namespace ILL\DataCiteDOIBundle\Model\Metadata;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Identifiers of related resources. Use this property to indicate subsets of properties, as appropriate.
 * Please see http://schema.datacite.org/meta/kernel-2.1/metadata.xsd for more detail.
 * @author Jamie Hall <hall@ill.eu>
 */
class RelatedIdentifier
{
    /**
     * @Type("string")
     * @Assert\NotNull()
     * @Assert\NotBlank()
     */
    private $identifier;

    /**
     * Please see http://schema.datacite.org/meta/kernel-2.1/include/datacite-relationType-v1.1.xsd for valid
     * relation types
     *
     * @SerializedName("relationType")
     * @Type("string")
     * @Assert\Choice(choices = { "IsCitedBy",
     *                            "Cites",
     *                            "IsSupplementedTo",
     *                            "IsSupplementedBy",
     *                            "IsContinuedBy",
     *                            "Continues",
     *                            "IsNewVersionOf",
     *                            "IsPreviousVersionOf",
     *                            "IsPartOf",
     *                            "HasPart",
     *                            "IsReferencedBy",
     *                            "References",
     *                            "IsDocumentedBy",
     *                            "Documents",
     *                            "IsCompiledBy",
     *                            "Compiles",
     *                            "IsVariantFormOf",
     *                            "IsOriginalFormOf"
     *                          },
     *                message = "Invalid relation type"
     *               )
     */
    private $relationType;

    /**
     * @SerializedName("relatedIdentifierType")
     * @Type("string")
     * @Assert\Choice(choices = { "ARK",
     *                            "DOI",
     *                            "EAN13",
     *                            "EISSN",
     *                            "Handle",
     *                            "ISBN",
     *                            "ISSN",
     *                            "ISTC",
     *                            "LISSN",
     *                            "LSID",
     *                            "PURL",
     *                            "UPC",
     *                            "URL",
     *                            "URN"
     *                          },
     *                message = "Invalid relation type"
     *               )
     */
    private $relatedIdentifierType;

    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function setRelationType($relationType)
    {
        $this->relationType = $relationType;

        return $this;
    }

    public function getRelationType()
    {
        return $this->relationType;
    }

    public function setRelatedIdentifierType($relatedIdentifierType)
    {
        $this->relatedIdentifierType = $relatedIdentifierType;

        return $this;
    }

    public function getRelatedIdentifierType()
    {
        return $this->relatedIdentifierType;
    }
}
