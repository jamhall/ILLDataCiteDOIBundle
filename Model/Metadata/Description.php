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
 * Please see http://schema.datacite.org/meta/kernel-2.1/metadata.xsd for more detail.
 * @author Jamie Hall <hall@ill.eu>
 */
class Description
{
    /**
     * @Type("string")
     * @Assert\NotNull()
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * Please see http://schema.datacite.org/meta/kernel-2.1/include/datacite-descriptionType-v1.1.xsd for valid
     * description types
     *
     * @Type("string")
     * @Assert\Choice(choices = { "Abstract",
     *                            "SeriesInformation",
     *                            "TableOfContents",
     *                            "Other"
     *                          },
     *                message = "Invalid description type"
     *               )
     */
    private $type;

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
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
