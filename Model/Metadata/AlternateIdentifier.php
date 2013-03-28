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

/**
 * An identifier other than the primary identifier applied to the resource being registered.
 * This may be any alphanumeric string which is unique within its domain of issue. The format is open
 * Please see http://schema.datacite.org/meta/kernel-2.1/metadata.xsd for more detail.
 * @author Jamie Hall <hall@ill.eu>
 */
class AlternateIdentifier
{
    /**
     * @Type("string")
     */
    private $identifier;

    /**
     * @Type("string")
     */
    private $type = null;

    public function setIdentifier($identifier)
    {
        if (null === $this->type) {
            throw new \InvalidArgumentException("Please set the type before setting the identifier");
        }
        $this->identifier = $identifier;

        return $this;
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function setType($type)
    {
        if (null === $type) {
            throw new \InvalidArgumentException("Type cannot be null");
        }
        $this->type = $type;

        return $this;
    }

    public function getType()
    {
        return $this->type;
    }
}
