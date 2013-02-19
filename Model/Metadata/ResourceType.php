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
 * The type of a resource. You may enter an additional free text description.
 * Please see http://schema.datacite.org/meta/kernel-2.0/metadata.xsd for more detail.
 */
class ResourceType
{
    private $type;
    private $resourceType;

    /**
     * Please see http://schema.datacite.org/meta/kernel-2.0/include/datacite-resourceType-v1.0.xsd for valid
     * general types
     */
    private static $RESOURCE_TYPES = array("Collection",
                                 "Dataset",
                                 "Event",
                                 "Film",
                                 "Image",
                                 "InteractiveResource",
                                 "PhysicalObject",
                                 "Service",
                                 "Software",
                                 "Sound",
                                 "Text");

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

    public function setResourceType($resourceType)
    {
        if (in_array($resourceType, self::RESOURCE_TYPES)) {
            $this->resourceType = $resourceType;

            return $this;
        } else {
            throw new \InvalidArgumentException(sprintf("Not a valid resource type. Valid types are: %s", json_encode(self::RESOURCE_TYPES)));
        }
    }

    public function getResourceType()
    {
        return $this->resourceType;
    }
}
