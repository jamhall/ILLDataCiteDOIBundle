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

use \Versionable\Prospect\Adapter\Curl;
/**
 * @author Jamie Hall <hall@ill.eu>
 */
class CurlAdapter extends AbstractAdapter
{
    public function __construct(array $config = array())
    {
        parent::initialise($config);
    }

    // return a curl adapter
    public function getAdapter()
    {
        $curl = new Curl();
        if ($this->proxy) {
            $curl->setOption(CURLOPT_PROXY, $this->proxy['host']);
               $curl->setOption(CURLOPT_PROXYPORT, $this->proxy['port']);
        }
        $curl->setOption(CURLOPT_USERPWD, sprintf("%s:%s", $this->username, $this->password));
        $curl->setOption(CURLOPT_SSLVERSION, parent::DATACITE_SSL_VERSION);

        return $curl;
    }
}
