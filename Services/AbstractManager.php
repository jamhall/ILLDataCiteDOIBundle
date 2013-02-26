<?php
/*
* This file is part of the ILLDataCiteDOIBundle package.
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*
* @License  MIT License
*/

namespace ILL\DataCiteDOIBundle\Services;
use ILL\DataCiteDOIBundle\Http\Adapter\CurlAdapter;

/**
 * @author Jamie Hall <hall@ill.eu>
 */
abstract class AbstractManager
{
    protected $adapter;
    protected $logger;
    /**
     * @var array $defaults Array of default options
     */
    protected $defaults = array(
        'username'    => null,
        'password'  => null,
        'prefix'    => null,
        'test'      => false,
        'testMode'  => false,
        'adapter'   => null,
        'proxy' => false
    );

    public function __construct(array $options = array(), $logger)
    {
        $this->defaults = array_merge($this->defaults, $options);
        $this->adapter = new CurlAdapter($this->defaults);
        $this->logger = $logger;
    }
}
