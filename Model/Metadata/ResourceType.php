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
 * The type of a resource. You may enter an additional free text description.
 * Please see http://schema.datacite.org/meta/kernel-2.2/metadata.xsd for more detail.
 * @author Jamie Hall <hall@ill.eu>
 */
class ResourceType
{
    /**
     * @Type("string")
     */
    private $type;

    /**
     * Please see http://schema.datacite.org/meta/kernel-2.2/include/datacite-resourceType-v2.xsd for valid
     * general types
     *
     * @SerializedName("resourceType")
     * @Type("string")
     * @Assert\Choice(choices = { "Collection",
     *                            "Dataset",
     *                            "Event",
     *                            "Film",
     *                            "Image",
     *                            "InteractiveResource",
     *                            "Model",
     *                            "PhysicalObject",
     *                            "Service",
     *                            "Software",
     *                            "Sound",
     *                            "Text"
     *                          },
     *                message = "Invalid resource type"
     *               )
     */
    private $resourceType;

    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setResourceType($resourceType)
    {
        $this->resourceType = $resourceType;

        return $this;
    }

    public function getResourceType()
    {
        return $this->resourceType;
    }
}
