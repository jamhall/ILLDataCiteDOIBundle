<?php
/*
* This file is part of the ILLDataCiteDOIBundle package.
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*
* @License  MIT License
*/

namespace ILL\DataCiteDOIBundle\Tests\Metadata;
use ILL\DataCiteDOIBundle\Services\DOIManager;
use ILL\DataCiteDOIBundle\Model\DOI;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class DOITest extends \PHPUnit_Framework_TestCase
{
    private $dm;

    public function setUp()
    {
      $log = new Logger('doi');
      $log->pushHandler(new StreamHandler(__DIR__ . '/../logs/doi.log'));
      $username = getenv('DATACITE_USERNAME');
      $password = getenv('DATACITE_PASSWORD');
      if (true == getenv("USE_PROXY")) {
        $config = array("username"=>$username,
                        "password"=>$password,
                        "proxy"=>array("host"=>getenv("PROXY_HOST"), "port"=>getenv("PROXY_PORT")));
      } else {
         $config = array("username"=>$username,"password"=>$password);
      }
      $this->dm = new DOIManager($config, $log, null);
    }

    /**
     * Attempt to create a DOI that doesn't exist. Should return a 412 error)
     */
    public function testCreate()
    {
        $doi = new DOI();
        $doi->setPrefix("10.5072");
        // generate a random suffix
        $doi->setSuffix(sha1(uniqid(mt_rand(), true)));
        $doi->setUrl("http://example.com");
        // 412: Precondition failed (metadata must be uploaded first)
        $this->assertEquals($this->dm->create($doi)->getCode(), 412);
    }

    /**
     * Find a DOI that exists in the handle system
     */
    public function testFind()
    {
        $this->assertFalse($this->dm->find(getenv("DATACITE_IDENTIFIER_EXISTS")) == null);
    }
}
