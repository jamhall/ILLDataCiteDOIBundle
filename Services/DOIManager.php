<?php

namespace ILL\DataCiteDOIBundle\Services;

use \Versionable\Prospect\Request\Request;
use \Versionable\Prospect\Url\Url;
use \Versionable\Prospect\Client\Client;
use \Versionable\Prospect\Header\BasicAuthentication;
use \Versionable\Prospect\Header\Collection;
use \Versionable\Prospect\Header\Accept;
use \Versionable\Prospect\Header\ContentType;

use ILL\DataCiteDOIBundle\Http\Adapter\CurlAdapter;
use ILL\DataCiteDOIBundle\Http\Response;
use ILL\DataCiteDOIBundle\Model\DOI;


class DOIManager
{
	private $doi = null;
	private $adapter = null;

	/**
     * @var array $defaults Array of default options
     */
    protected $defaults = array(
        'username'    => null,
        'password'  => null,
        'prefix'	=> null,
        'test'		=> false,
        'testMode'	=> false,
        'adapter'	=> null,
        'proxy' => false
    );

	public function __construct(array $options = array())
	{
		$this->defaults = array_merge($this->defaults, $options);

		if("curl" === $this->defaults['adapter']) {
			$this->adapter = new CurlAdapter($this->defaults);
		} else {
			throw new \Exception("We don't currently support the socket protocol for the moment");
		}
	}

	public function findById($id)
	{
	    $request = new Request(new Url($this->adapter->getDoiGetUri($id)));
	    $client = new Client($this->adapter->getAdapter());
	    $response = $client->send($request, new Response());

	    try {
	    	// check the response is valid
	    	if($response->isValid()) {
		   		$this->doi = new DOI();
		   		$this->doi->setId($id)
		   				  ->setUrl($response->getContent());
		   		return $this->doi;
	    	}
	    } catch(\Exception $e) {
	    	return null;
	    }
	}
}