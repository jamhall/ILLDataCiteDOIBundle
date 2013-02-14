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
	 * The identifier
	 *
	 * @var string
	 */
	protected $id;

	/**
	 * The URL for the DOI
	 *
	 * @var string
	 */
	protected $url;

	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}

    /**
	 * Gets the id
	 *
	 * @return string
	 */
	public function getId()
	{
		return $this->id;
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