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
 * Unstructures size information about the resource
 * If an embargo period has been in effect, use the date when the embargo period ends.
 * Please see http://schema.datacite.org/meta/kernel-2.0/metadata.xsd for more detail.
 * @author Jamie Hall <hall@ill.eu>
 */
class Size
{
    /**
     * @Type("string")
     */
    private $size;

    public function __construct($size = null)
    {
        if (null !== $size) {
            $this->size = $size;
        }
    }

    public function setSize($size)
    {
        if (null === $size) {
            throw new \InvalidArgumentException("Size cannot be empty");
        } else {
            $this->size = $size;

            return $this;
        }
    }

    public function getSize()
    {
        return $this->size;
    }
}
