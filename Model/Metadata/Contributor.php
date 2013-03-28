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
use ILL\DataCiteDOIBundle\Model\Metadata\Validator\NonEmptyStringValidator;
use ILL\DataCiteDOIBundle\Model\Metadata\NameIdentifier;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Exclude;
/**
 * The institution or person responsible for collecting, creating, or otherwise contributing to the developement of the dataset.
 * Please see http://schema.datacite.org/meta/kernel-2.1/metadata.xsd for more detail.
 * @author Jamie Hall <hall@ill.eu>
 */
class Contributor
{
    /**
     * @Type("string")
     */
    private $name;

    /**
     * @Type("string")
     */
    private $type;

    /**
     * @SerializedName("nameIdentifier")
     * @Type("ILL\DataCiteDOIBundle\Model\Metadata\NameIdentifier")
     */
    private $nameIdentifier;

    /**
     * Please see http://schema.datacite.org/meta/kernel-2.1/include/datacite-contributorType-v1.1.xsd for valid
     * contriutor types
     * @Exclude()
     */
    private static $TYPES = array("ContactPerson",
        "DataCollector",
        "DataManager",
        "Editor",
        "HostingInstitution",
        "ProjectLeader",
        "ProjectMember",
        "RegistrationAgency",
        "RegistrationAuthority",
        "Researcher",
        "WorkPackageLeader");

    public function setName($name)
    {
        if (NonEmptyStringValidator::isValid("name", $name)) {
            $this->name = $name;
        }

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setType($type)
    {
        if (in_array($type, self::$TYPES)) {
            $this->type = $type;

            return $this;
        } else {
            throw new \InvalidArgumentException(sprintf("Not a valid type. Valid types are: %s", json_encode(self::$TYPES)));
        }
    }

    public function getType()
    {
        return $this->type;
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
