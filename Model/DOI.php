<?php
/*
* This file is part of the ILLDataCiteDOIBundle package.
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*
* @License  MIT License
*/

namespace ILL\DataCiteDOIBundle\Model;
/*
 * This class represents a DOI
 */
class DOI 
{
    /**
	 * The DOI identifier
	 *
	 * @var string
	 */
	protected $doi;

	/**
	 * The URL for the DOI
	 *
	 * @var string
	 */
	protected $url;

	public function setDoi($doi)
	{
		$this->doi = $doi;
		return $this;
	}

    /**
	 * Gets the DOI
	 *
	 * @return string
	 */
	public function getDoi()
	{
		return $this->doi;
	}

	public function setUrl($url)
	{
		$this->url = $url;
		return $this;
	}

    /**
	 * Gets the URL for the DOI
	 *
	 * @return string
	 */
	public function getUrl()
	{
		return $this->url;
	}
}