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
use ILL\DataCiteDOIBundle\Model\Metadata\NameIdentifier;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * The main researchers involved working on the data, or the authors of the publication in
 * priority order. May be a corporate/institutional or personal name.
 * Please see http://schema.datacite.org/meta/kernel-2.1/metadata.xsd for more detail.
 * @author Jamie Hall <hall@ill.eu>
 */
class Creator
{
    /**
     * @Type("string")
     * @Assert\NotNull()
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @SerializedName("nameIdentifier")
     * @Type("ILL\DataCiteDOIBundle\Model\Metadata\NameIdentifier")
     */
    private $nameIdentifier;

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setNameIdentifier(NameIdentifier $nameIdentifier)
    {
        $this->nameIdentifier = $nameIdentifier;

        return $this;
    }

    public function getNameIdentifier()
    {
        return $this->nameIdentifier;
    }
}
