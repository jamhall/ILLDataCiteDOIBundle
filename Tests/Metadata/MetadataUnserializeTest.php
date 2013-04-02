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
use ILL\DataCiteDOIBundle\Model\Metadata;
use ILL\DataCiteDOIBundle\Model\Metadata\AlternateIdentifier;
use ILL\DataCiteDOIBundle\Model\Metadata\Creator;
use ILL\DataCiteDOIBundle\Model\Metadata\Contributor;
use ILL\DataCiteDOIBundle\Model\Metadata\Date;
use ILL\DataCiteDOIBundle\Model\Metadata\Description;
use ILL\DataCiteDOIBundle\Model\Metadata\Format;
use ILL\DataCiteDOIBundle\Model\Metadata\RelatedIdentifier;
use ILL\DataCiteDOIBundle\Model\Metadata\ResourceType;
use ILL\DataCiteDOIBundle\Model\Metadata\Size;
use ILL\DataCiteDOIBundle\Model\Metadata\Subject;
use ILL\DataCiteDOIBundle\Model\Metadata\Title;
use ILL\DataCiteDOIBundle\Model\Metadata\NameIdentifier;

class MetadataUnserializeTest extends \PHPUnit_Framework_TestCase
{
    private $metadata;

    public function setUp()
    {
        $this->metadata = new Metadata();
        $this->metadata->setIdentifier("10.1594/WDCC/CCSRNIES_SRES_B2")
                       ->setPublisher("World Data Center for Climate (WDCC)")
                       ->setPublicationYear("2004")
                       ->addCreator((new Creator)->setName("Miller, John"))
                       ->addCreator((new Creator)->setName("Smith, Jane")
                                               ->setNameIdentifier((new NameIdentifier)->setScheme("ISNI")
                                                                                       ->setIdentifier("1422 4586 3573 0476")))
                       ->addTitle((new Title)->setTitle("National Institute for Environmental Studies and Center for Climate System Research Japan"))
                       ->addTitle((new Title)->setTitle("A survey")
                                           ->setType("Subtitle"))
                       ->addSubject((new Subject)->setSubject("Earth sciences and geology"))
                       ->addSubject((new Subject)->setSubject("551 Geology, hydrology, meteorology")
                                               ->setScheme("DDC"))
                       ->addContributor((new Contributor)->setType("DataManager")
                                                       ->setName("PANGAEA"))
                       ->addContributor((new Contributor)->setType("ContactPerson")
                                                       ->setName("Doe, John")
                                                       ->setNameIdentifier((new NameIdentifier)->setScheme("ORCID")
                                                                                               ->setIdentifier("xyz789")))
                       ->addDate((new Date)->setType("Valid")
                                         ->setDate("2005-04-05"))
                       ->addDate((new Date)->setType("Accepted")
                                         ->setDate("2005-01-01"))
                       ->setResourceType((new ResourceType)->setResourceType("Image")
                                                         ->setType("Animation"))
                       ->addAlternateIdentifier((new AlternateIdentifier)->setType("ISBN")
                                                                       ->setIdentifier("937-0-1234-56789-X"))
                       ->addRelatedIdentifier((new RelatedIdentifier)->setRelatedIdentifierType("DOI")
                                                                   ->setRelationType("IsCitedBy")
                                                                   ->setIdentifier("10.1234/testpub"))
                       ->addRelatedIdentifier((new RelatedIdentifier)->setRelatedIdentifierType("URN")
                                                                   ->setRelationType("Cites")
                                                                   ->setIdentifier("http://testing.ts/testpub"))
                       ->addSize(new Size("285 kb"))
                       ->addSize(new Size("100 pages"))
                       ->addFormat(new Format("text/plain"))
                       ->setRights("Open Database License [ODbL]")
                       ->setVersion("1.0")
                       ->setLanguage("eng")
                       ->addDescription((new Description)->setType("Other")
                                                         ->setDescription("The current xml-example for a DataCite record is the official example from the documentation.\n\t\tPlease look on datacite.org to find the newest versions of sample data and schemas."));

    }

    public function testUnserialize() {
        $xml = file_get_contents(__DIR__ . "/Resources/datacite-metadata-sample-v2.2.xml");
        $serializedMetadata = MetadataSerializer::unserialize($xml);
        /**
         * The serialized metadata from the XML file should be exactly the same as
         * our predefined metadata object
         */
        $this->assertEquals($this->metadata, $serializedMetadata);
    }

}
