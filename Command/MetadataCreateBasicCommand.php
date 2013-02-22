<?php
namespace ILL\DataCiteDOIBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ILL\DataCiteDOIBundle\Model\Metadata;
use ILL\DataCiteDOIBundle\Model\Metadata\Creator;
use ILL\DataCiteDOIBundle\Model\Metadata\Title;
use ILL\DataCiteDOIBundle\Model\Metadata\NameIdentifier;
use ILL\DataCiteDOIBundle\Model\Metadata\Subject;
use ILL\DataCiteDOIBundle\Model\Metadata\Contributor;
use ILL\DataCiteDOIBundle\Model\Metadata\Date;
use ILL\DataCiteDOIBundle\Model\Metadata\ResourceType;
use ILL\DataCiteDOIBundle\Model\Metadata\AlternateIdentifier;
use ILL\DataCiteDOIBundle\Model\Metadata\RelatedIdentifier;
use ILL\DataCiteDOIBundle\Model\Metadata\Size;
use ILL\DataCiteDOIBundle\Model\Metadata\Format;
use ILL\DataCiteDOIBundle\Model\Metadata\Description;
class MetadataCreateBasicCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('doi:metadata:create-basic')
            ->setDescription('Upload metadata with the minimum required attributes')
            ->addArgument(
                'doi',
                InputArgument::OPTIONAL,
                'The DOI id?'
            )
            ->addArgument(
                'url',
                InputArgument::OPTIONAL,
                'The DOI url?'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getApplication()->getKernel()->getContainer();
        $doi = $input->getArgument('doi');
        $url = $input->getArgument('url');
        $metadataManager = $container->get("ill_data_cite_doi.metadata_manager");

        $metadata = new Metadata();
        $metadata->setIdentifier("10.1594/WDCC/CCSRNIES_SRES_B2")
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
                                                   ->setName("PANGEA"))
                 ->addContributor((new Contributor)->setType("ContactPerson")
                                                   ->setName("Doe, John")
                                                   ->setNameIdentifier((new NameIdentifier)->setScheme("ORCID")
                                                                                           ->setIdentifier("xyz780")))
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
                 ->addRelatedIdentifier((new RelatedIdentifier)->setRelatedIdentifierType("DOI")
                                                               ->setRelationType("IsCitedBy")
                                                               ->setIdentifier("10.1234/testpub"))
                 ->addSize(new Size("285 kb"))
                 ->addSize(new Size("100 pages"))
                 ->addFormat(new Format("text/plain"))
                 ->setRights("Open Database License [ODbL]")
                 ->setVersion("1.0")
                 ->setLanguage("eng")
                 ->addDescription((new Description)->setType("Other")
                                                   ->setDescription('The current xml-example for a DataCite record is the official example from the documentation.<br/>Please look on datacite.org to find the newest versions of sample data and schemas.'));
        // serialize to xml
        $metadateSerializer = $container->get("ill_data_cite_doi.metadata_serializer");
        $xml = $metadateSerializer::serialize($metadata);
        $xmlUnserialized = $metadateSerializer::unserialize($xml);
    }
}
