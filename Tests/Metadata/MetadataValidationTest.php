<?php
namespace ILL\DataCiteDOIBundle\Tests\Metadata;
use Symfony\Component\Validator\Validation;
use ILL\DataCiteDOIBundle\Services\Serializer\MetadataSerializer;

class MetadataValidationTest extends \PHPUnit_Framework_TestCase
{
    public function testValidationExampleOne()
    {
        $xml = file_get_contents(__DIR__ . "/Resources/datacite-metadata-sample-v2.2.xml");
        $metadata = MetadataSerializer::unserialize($xml);
        $validator = Validation::createValidatorBuilder()->enableAnnotationMapping()->getValidator();
        $errors = $validator->validate($metadata);
        $this->assertEquals(0, count($errors));
    }

    public function testValidationExampleTwo()
    {
        $xml = file_get_contents(__DIR__ . "/Resources/datacite-metadata-sample-article-v2.2.xml");
        $metadata = MetadataSerializer::unserialize($xml);
        $validator = Validation::createValidatorBuilder()->enableAnnotationMapping()->getValidator();
        $errors = $validator->validate($metadata);
        $this->assertEquals(0, count($errors));
    }

    public function testValidationExampleThree()
    {
        $xml = file_get_contents(__DIR__ . "/Resources/datacite-metadata-sample-conference-related1-v2.2.xml");
        $metadata = MetadataSerializer::unserialize($xml);
        $validator = Validation::createValidatorBuilder()->enableAnnotationMapping()->getValidator();
        $errors = $validator->validate($metadata);
        $this->assertEquals(0, count($errors));
    }

    public function testValidationExampleFour()
    {
        $xml = file_get_contents(__DIR__ . "/Resources/datacite-metadata-sample-conference-related2-v2.2.xml");
        $metadata = MetadataSerializer::unserialize($xml);
        $validator = Validation::createValidatorBuilder()->enableAnnotationMapping()->getValidator();
        $errors = $validator->validate($metadata);
        $this->assertEquals(0, count($errors));

    }

    public function testValidationExampleFive()
    {
        $xml = file_get_contents(__DIR__ . "/Resources/datacite-metadata-sample-video-v2.2.xml");
        $metadata = MetadataSerializer::unserialize($xml);
        $validator = Validation::createValidatorBuilder()->enableAnnotationMapping()->getValidator();
        $errors = $validator->validate($metadata);
        $this->assertEquals(0, count($errors));
    }

    public function testValidationExampleSix()
    {
        $xml = file_get_contents(__DIR__ . "/Resources/datacite-metadata-sample-3Dmodel-v2.2.xml");
        $metadata = MetadataSerializer::unserialize($xml);
        $validator = Validation::createValidatorBuilder()->enableAnnotationMapping()->getValidator();
        $errors = $validator->validate($metadata);
        var_dump($errors);
        $this->assertEquals(0, count($errors));
    }
}
