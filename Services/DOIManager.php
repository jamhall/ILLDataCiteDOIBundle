<?php

namespace ILL\DataCiteDOIBundle\Services;

use Versionable\Prospect\Request\Request;
use Versionable\Prospect\Url\Url;
use Versionable\Prospect\Adapter\Curl;
use Versionable\Prospect\Client\Client;
use Versionable\Prospect\Response\Response;

class DOIManager
{
	public function __construct(array $options = array())
	{

		    $request = new \Versionable\Prospect\Request\Request(new Url('http://versionable.co.uk/'));
		var_dump($options);
	}

	// main functions for creating, updating and deleting DOIs
	// 
	public function create() {}

	public function delete() {}

	public function update() {}


}

?>
