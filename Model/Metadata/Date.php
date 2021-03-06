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
 * Year when the data is made publicly available.
 * If an embargo period has been in effect, use the date when the embargo period ends.
 * Please see http://schema.datacite.org/meta/kernel-2.2/metadata.xsd for more detail.
 * @author Jamie Hall <hall@ill.eu>
 */
class Date
{
    /**
     * @Type("string")
     * @Assert\NotNull()
     * @Assert\NotBlank()
     */
    private $date;

    /**
     * The type of date. To indicate a date period, provide two dates, specifying the StartDate and the EndDate.
     * To indicate the end of an embargo period. use Available.
     * To indicate the start of an embargo period, use Submitted or Accepted, as appropriate.
     * Please see http://schema.datacite.org/meta/kernel-2.2/include/datacite-dateType-v2.xsd for valid date types
     *
     * @Type("string")
     * @Assert\Choice(choices = { "Accepted",
     *                            "Available",
     *                            "Copyrighted",
     *                            "Created",
     *                            "EndDate",
     *                            "Issued",
     *                            "StartDate",
     *                            "Submitted",
     *                            "Updated",
     *                            "Valid"
     *                          },
     *                message = "Invalid date type"
     *               )
     */
    private $type;

    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    public function getDate()
    {
        return $this->date;
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
