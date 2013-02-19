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

/**
 * Identifiers of related resources. Use this property to indicate subsets of properties, as appropriate.
 * Please see http://schema.datacite.org/meta/kernel-2.1/metadata.xsd for more detail.
 * @author Jamie Hall <hall@ill.eu>
 */
class RelatedIdentifier
{
    private $identifier;
    private $relationType;
    private $relatedIdentifierType;

    /**
     * Please see http://schema.datacite.org/meta/kernel-2.1/include/datacite-relationType-v1.1.xsd for valid
     * relation types
     */
    private static $RELATION_TYPES = array("IsCitedBy",
                                            "Cites",
                                            "IsSupplementedTo",
                                            "IsSupplementedBy",
                                            "IsContinuedBy",
                                            "Continues",
                                            "IsNewVersionOf",
                                            "IsPreviousVersionOf",
                                            "IsPartOf",
                                            "HasPart",
                                            "IsReferencedBy",
                                            "References",
                                            "IsDocumentedBy",
                                            "Documents",
                                            "IsCompiledBy",
                                            "Compiles",
                                            "IsVariantFormOf",
                                            "IsOriginalFormOf");

    /**
     * Please see http://schema.datacite.org/meta/kernel-2.1/include/datacite-relatedIdentifierType-v1.1.xsd for valid
     * related identifier types
     */
    private static $RELATED_IDENTIFIER_TYPES = array("ARK",
                                                    "DOI",
                                                    "EAN13",
                                                    "EISSN",
                                                    "Handle",
                                                    "ISBN",
                                                    "ISSN",
                                                    "ISTC",
                                                    "LISSN",
                                                    "LSID",
                                                    "PURL",
                                                    "UPC",
                                                    "URN");

    public function setIdentifier($identifier)
    {
        if (null === $this->relationType || null === $this->relatedIdentifierType) {
            throw new \InvalidArgumentException("Please set the relation type and the related identifier type before setting the identifier");
        }
        $this->identifier = $identifier;

        return $this;
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function setRelationType($relationType)
    {
        if (in_array($relationType, self::RELATION_TYPES)) {
            $this->relationType = $relationType;

            return $this;
        } else {
            throw new \InvalidArgumentException(sprintf("Not a valid relation type. Valid relation types are: %s", json_encode(self::RELATION_TYPES)));
        }
    }

    public function getRelationType()
    {
        return $this->relationType;
    }

    public function setRelatedIdentifierType($relatedIdentifierType)
    {
        if (in_array($relatedIdentifierType, self::RELATED_IDENTIFIER_TYPES)) {
            $this->relatedIdentifierType = $relatedIdentifierType;

            return $this;
        } else {
            throw new \InvalidArgumentException(sprintf("Not a valid related identifier type. Valid related identifier types are: %s", json_encode(self::RELATED_IDENTIFIER_TYPES)));
        }
    }

    public function getRelatedIdentifierType()
    {
        return $this->relatedIdentifierType;
    }
}
