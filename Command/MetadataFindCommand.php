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
class MetadataFindCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('doi:metadata:find')
            ->setDescription('Upload metadata with the minimum required attributes')
            ->addArgument(
                'doi',
                InputArgument::REQUIRED,
                'The DOI id?'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getApplication()->getKernel()->getContainer();
        $doi = $input->getArgument('doi');
        $metadataManager = $container->get("ill_data_cite_doi.metadata_manager");
        $metadata = $metadataManager->find($doi);
        if($metadata) {
            $output->writeln(var_dump($metadata));
        } else {
            $output->writeln(sprintf("Couldn't find metadata for the DOI: <error>%s</error>", $doi));
        }
    }
}
