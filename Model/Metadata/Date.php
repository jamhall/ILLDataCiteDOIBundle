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
 * Year when the data is made publicly available.
 * If an embargo period has been in effect, use the date when the embargo period ends.
 * Please see http://schema.datacite.org/meta/kernel-2.0/metadata.xsd for more detail.
 */
class Date
{
    private $date;
    private $type;

   /**
    * The type of date. To indicate a date period, provide two dates, specifying the StartDate and the EndDate.
    * To indicate the end of an embargo period. use Available.
    * To indicate the start of an embargo period, use Submitted or Accepted, as appropriate.
    */
    private static $TYPES = array("Accepted",
                        "Available",
                        "Copyrighted",
                        "Created",
                        "EndDate",
                        "Issued",
                        "StartDate",
                        "Submitted",
                        "Updated",
                        "Valid");

    public function setDate($date)
    {
        // check if date matches a format described in W3CDTF (http://www.w3.org/TR/NOTE-datetime)
        if (true === preg_match("/(\d{4})-(\d{2})-(\d{2})T(\d{2}):(\d{2})(:(\d{2}))?(?:([-+])(\d{2}):?(\d{2})|(Z))?/" , $date)) {
            $this->date = $date;

            return $this;
        }
        throw new \InvalidArgumentException("Not a valid date. It must be in the format of YYYY or YYYY-MM-DD or any other format described in W3CDTF (http://www.w3.org/TR/NOTE-datetime)");
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
