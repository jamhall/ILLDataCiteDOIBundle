<?php

namespace ILL\DataCiteDOIBundle\Http\Adapter;

use \Versionable\Prospect\Adapter\Curl;

class CurlAdapter extends BaseAdapter
{
	public function __construct(array $config = array())
	{
		$this->username = $config['username'];
		$this->password = $config['password'];
		$this->prefix = $config['prefix'];
		$this->test = $config['test'];
		$this->testMode = $config['testMode'];
		$this->proxy = $config['proxy'];
	}

	// return a curl adapter
	public function getAdapter()
	{
		$curl = new Curl();
		if($this->proxy) {
		    $curl->setOption(CURLOPT_PROXY, $this->proxy['host']);
		   	$curl->setOption(CURLOPT_PROXYPORT, $this->proxy['port']);
		}
		$curl->setOption(CURLOPT_USERPWD, $this->username . ":" . $this->password);
	    $curl->setOption(CURLOPT_SSLVERSION, parent::DATACITE_SSL_VERSION);
	    return $curl;
	}

	public function setProxy(array $settings = array()) 
	{
		$this->proxy = $settings;
	}
}