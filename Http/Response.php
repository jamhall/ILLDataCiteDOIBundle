<?php
/*
* This file is part of the ILLDataCiteDOIBundle package.
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*
* @License  MIT License
*/

namespace ILL\DataCiteDOIBundle\Http;

/**
 * @author Jamie Hall <hall@ill.eu>
 */
class Response extends \Versionable\Prospect\Response\Response
{
	public function isValid()
	{
	   	if(in_array($this->code, array("200", "201"))) {
	   		return true;
	   	}
    	throw new \Exception($this->code . ":" . self::$valid_codes[$this->code]);
	}
}