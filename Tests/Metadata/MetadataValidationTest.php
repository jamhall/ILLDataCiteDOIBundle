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
use Symfony\Component\Validator\Validation;
use ILL\DataCiteDOIBundle\Services\Serializer\MetadataSerializer;
use ILL\DataCiteDOIBundle\Services\MetadataManager;

class MetadataValidationTest extends \PHPUnit_Framework_TestCase
{
    private $mdm;

    public function setUp()
    {
        /**
         * As the validation for the identifier is done by a regular expression this allows us to
         * define many prefixes. Normally, however, you would have one.
         */
        $this->mdm = new MetadataManager(array("prefix"=>"10.5072|10.1594|10.2312|10.4122"), null, Validation::createValidatorBuilder()->enableAnnotationMapping()->getValidator());
    }

    public function testValidationExampleOne()
    {
        $xml = file_get_contents(__DIR__ . "/Resources/datacite-metadata-sample-v2.2.xml");
        $metadata = MetadataSerializer::unserialize($xml);
        $this->assertEquals(0, count($this->mdm->isValid($metadata)));
    }

    public function testValidationExampleTwo()
    {
        $xml = file_get_contents(__DIR__ . "/Resources/datacite-metadata-sample-article-v2.2.xml");
        $metadata = MetadataSerializer::unserialize($xml);
        $this->assertEquals(0, count($this->mdm->isValid($metadata)));
    }

    public function testValidationExampleThree()
    {
        $xml = file_get_contents(__DIR__ . "/Resources/datacite-metadata-sample-conference-related1-v2.2.xml");
        $metadata = MetadataSerializer::unserialize($xml);
        $this->assertEquals(0, count($this->mdm->isValid($metadata)));
    }

    public function testValidationExampleFour()
    {
        $xml = file_get_contents(__DIR__ . "/Resources/datacite-metadata-sample-conference-related2-v2.2.xml");
        $metadata = MetadataSerializer::unserialize($xml);
        $this->assertEquals(0, count($this->mdm->isValid($metadata)));
    }

    public function testValidationExampleFive()
    {
        $xml = file_get_contents(__DIR__ . "/Resources/datacite-metadata-sample-video-v2.2.xml");
        $metadata = MetadataSerializer::unserialize($xml);
        $this->assertEquals(0, count($this->mdm->isValid($metadata)));
    }

    public function testValidationExampleSix()
    {
        $xml = file_get_contents(__DIR__ . "/Resources/datacite-metadata-sample-3Dmodel-v2.2.xml");
        $metadata = MetadataSerializer::unserialize($xml);
        $this->assertEquals(0, count($this->mdm->isValid($metadata)));
    }
}
