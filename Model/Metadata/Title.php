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
use Symfony\Component\Validator\Constraints as Assert;

/**
 * A name or title by which a resource is known.
 * Please see http://schema.datacite.org/meta/kernel-2.1/metadata.xsd for more detail.
 * @author Jamie Hall <hall@ill.eu>
 */
class Title
{
    /**
     * @Type("string")
     * @Assert\NotNull()
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @Type("string")
     * @Assert\Choice(choices = { "AlternativeTitle",
     *                            "Subtitle",
     *                            "TranslatedTitle"
     *                          },
     *                message = "Invalid title type"
     *               )
     */
    private $type;

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
            $this->type = $type;

            return $this;

    }

    public function getType()
    {
        return $this->type;
    }
}
