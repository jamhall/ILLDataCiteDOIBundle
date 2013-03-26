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
use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Exception\ParseException;

/**
 * @author Jamie Hall <hall@ill.eu>
 */
abstract class AbstractManager
{
    protected $adapter;
    protected $logger;
    /**
     * YAML object of expected API methods response codes
     * @var [type]
     */
    protected static $responseCodes;
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
        self::$responseCodes = $this->loadResponseCodes();
    }

    private function loadResponseCodes()
    {
        $yaml = new Parser();
        try {
            return $yaml->parse(file_get_contents(__DIR__.'/../Resources/config/api_response_codes.yml'));
        } catch (ParseException $e) {
            throw new ParseException(sprintf("Unable to parse the api_response_codes.yml file: %s", $e->getMessage()));
        }
    }

    public function getResponseCodes($method)
    {
        try {
            return self::$responseCodes[$method]['codes'];
        } catch (\Exception $e) {
            throw new \Exception(sprintf("The method %s was not found in the codes yaml file", $method));
        }
    }

    public function getConfiguration()
    {
        return $this->defaults;
    }
}
