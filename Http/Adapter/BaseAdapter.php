<?php
namespace ILL\DataCiteDOIBundle\Http\Adapter;

abstract class BaseAdapter
{
	// the API end point for the datacite api
	const DATACITE_API_ENDPOINT = "https://mds.datacite.org";
	// the SSL version for the datacite api
	const DATACITE_SSL_VERSION = 3;
	// the default test prefix for the datacite api
	const DATACITE_TEST_PREFIX = "10.5072";

	// common attributes for all adapters
	protected $username = null;
	protected $password = null;
	protected $prefix = null;
	protected $testMode = false;
	protected $test = false;
	protected $proxy = false;

	protected function initialise(array $config = array())
	{
		$this->username = $config['username'];
		$this->password = $config['password'];
		$this->prefix = (true === $config['test']) ? self::DATACITE_TEST_PREFIX : $config['prefix'];
		$this->test = $config['test'];
		$this->testMode = $config['testMode'];
		$this->proxy = $config['proxy'];
	}
	public function setUsername($username)
	{
		$this->username = $username;
		return $this;
	}

	public function getUsername()
	{
		return $this->username;
	}

	public function setPassword($password)
	{
		$this->password = $password;
		return $this;
	}

	public function getPassword()
	{
		return $this->password;
	}

	public function setTestMode($testMode)
	{
		$this->testMode = $testMode;
		return $this;
	}

	public function getTestMode()
	{
		return $this->testMode();
	}

	public function setTest($test)
	{
		$this->test = $test;
		return $this;
	}

	public function getTest()
	{
		return $this->test;
	}

	public function setPrefix($prefix)
	{
		$this->prefix = $prefix;
	}

	public function getPrefix() {
		return $this->prefix;
	}

	public function setProxy(array $settings = array()) 
	{
		$this->proxy = $settings;
	}

	// URIs for datacite
	public function getDoiPostUri() {
		return sprintf("%s/doi", self::DATACITE_API_ENDPOINT);
	}

	public function getDoiGetUri($doi) {
		return sprintf("%s/doi/%s/%s", self::DATACITE_API_ENDPOINT, $this->prefix, $doi);
	}

	public function getMetadataGetDeleteUri($doi) {
		return sprintf("%s/metadata/%s", self::DATACITE_API_ENDPOINT, $doi);
	}

	public function getMetadataPostUri() {
		return sprintf("%s/metadata", self::DATACITE_API_ENDPOINT);
	}

	public function getMediaGetPostUri($doi)
	{
		return sprintf("%s/media/%s", self::DATACITE_API_ENDPOINT, $doi);
	}

}