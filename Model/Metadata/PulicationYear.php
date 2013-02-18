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
class PublicationYear
{
	private $year;

	public function __construct($year = null)
	{
		if (null !== $year) {
        	$this->setYear($year);
  		}
	}

	public function setYear($year)
	{
		// check if a valid year
		if(true === preg_match("^\d{4}$" , $year)) {
			$this->year = $year;
			return $this;
		}
		throw new \Exception("Not a valid year. It must be of the format: YYYY");
	}
}