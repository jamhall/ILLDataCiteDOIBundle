<?php
namespace ILL\DataCiteDOIBundle\Http;

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