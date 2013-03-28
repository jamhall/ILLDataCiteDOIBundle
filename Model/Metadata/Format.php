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
 * Technical format of the resource. Use file extension or MIME type where possible.
 * If an embargo period has been in effect, use the date when the embargo period ends.
 * Please see http://schema.datacite.org/meta/kernel-2.1/metadata.xsd for more detail.
 * @author Jamie Hall <hall@ill.eu>
 */
class Format
{

    /**
     * @Type("string")
     */
    private $format;

    public function __construct($format = null)
    {
        if (null !== $format) {
            $this->format = $format;
        }
    }

    public function setFormat($format)
    {
        if (null === $format) {
            throw new \InvalidArgumentException("Format cannot be empty");
        } else {
            $this->format= $format;

            return $this;
        }
    }

    public function getFormat()
    {
        return $this->format;
    }
}
