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
 * A name or title by which a resource is known.
 * Please see http://schema.datacite.org/meta/kernel-2.1/metadata.xsd for more detail.
 * @author Jamie Hall <hall@ill.eu>
 */
class Title
{
    private $title;
    private $type;

    static public function instantiate()
    {
        return new self();
    }

    /**
     * Please see http://schema.datacite.org/meta/kernel-2.0/include/datacite-titleType-v1.0.xsd for valid
     * title types
     */
    private static $TYPES = array("AlternativeTitle", "Subtitle", "TranslatedTitle");

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setType($type)
    {
        if (in_array($type, self::TYPES)) {
            $this->type = $type;

            return $this;
        } else {
            throw new \InvalidArgumentException(sprintf("Not a valid type. Valid types are: %s", json_encode(self::TYPES)));
        }
    }

    public function getType()
    {
        return $this->type;
    }
}
