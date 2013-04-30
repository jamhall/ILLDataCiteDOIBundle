<?php
/*
* This file is part of the ILLDataCiteDOIBundle package.
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*
* @License  MIT License
*/

namespace ILL\DataCiteDOIBundle\Http\Adapter;

/**
 * @author Jamie Hall <hall@ill.eu>
 */
abstract class AbstractAdapter
{
    // the API end point for the datacite api
    const DATACITE_API_ENDPOINT = "https://mds.datacite.org";

    // the SSL version for the datacite api
    const DATACITE_SSL_VERSION = 3;

    // common attributes for all adapters
    protected $username = null;
    protected $password = null;
    protected $prefix = null;
    protected $proxy = false;

    protected function initialise(array $config = array())
    {
        $this->username = $config['username'];
        $this->password = $config['password'];
        $this->prefix = $config['prefix'];
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

    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
    }

    public function getPrefix()
    {
        return $this->prefix;
    }

    public function setProxy(array $settings = array())
    {
        $this->proxy = $settings;
    }

    // URIs for datacite
    public function getDoiPostUri()
    {
        return sprintf("%s/doi", self::DATACITE_API_ENDPOINT);
    }

    public function getDoiGetUri($doi)
    {
        return sprintf("%s/doi/%s", self::DATACITE_API_ENDPOINT, $doi);
    }

    public function getMetadataGetDeleteUri($doi)
    {
        return sprintf("%s/metadata/%s", self::DATACITE_API_ENDPOINT, $doi);
    }

    public function getMetadataPostUri()
    {
        return sprintf("%s/metadata", self::DATACITE_API_ENDPOINT);
    }

    public function getMediaGetPostUri($doi)
    {
        return sprintf("%s/media/%s/%s", self::DATACITE_API_ENDPOINT, $this->prefix, $doi);
    }

}
