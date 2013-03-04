<?php
/*
* This file is part of the ILLDataCiteDOIBundle package.
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*
* @License  MIT License
*/

namespace ILL\DataCiteDOIBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ILL\DataCiteDOIBundle\Model\Metadata;
use ILL\DataCiteDOIBundle\Model\Metadata\Creator;
use ILL\DataCiteDOIBundle\Model\Metadata\Title;

/**
 * A command for the creation of metadata. Please refer to the API documentation:
 * https://mds.datacite.org/static/apidoc
 * @author Mr. Jamie Hall <hall@ill.eu>
 */
class MetadataCreateBasicCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('doi:metadata:create-basic')
            ->setDescription('Upload metadata to datacite with the minimum required attributes')
            ->addArgument(
                'identifier',
                InputArgument::REQUIRED,
                'An identifier'
            )
            ->addArgument(
                'creator',
                InputArgument::REQUIRED,
                'A creator'
            )
            ->addArgument(
                'title',
                InputArgument::REQUIRED,
                'A title'
            )
            ->addArgument(
                'publisher',
                InputArgument::REQUIRED,
                'A publisher'
            )
            ->addArgument(
                'publicationYear',
                InputArgument::REQUIRED,
                'A publication year'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getApplication()->getKernel()->getContainer();
        $metadataManager = $container->get("ill_data_cite_doi.metadata_manager");

        $identifier = $input->getArgument('identifier');
        $creator = $input->getArgument('creator');
        $title = $input->getArgument('title');
        $publisher = $input->getArgument('publisher');
        $publicationYear = $input->getArgument('publicationYear');

        $metadata = new Metadata();
        $metadata->setIdentifier($identifier)
                 ->setPublisher($publisher)
                 ->setPublicationYear($publicationYear)
                 ->addCreator((new Creator)->setName($creator))
                 ->addTitle((new Title)->setTitle($title));

        if ($metadataManager->create($metadata)) {
            $output->writeln(sprintf("Created metadata for the identifier: <info>%s</info>", $identifier));
        } else {
            $output->writeln(sprintf("Couldn't create the metadata for the identifier: <info>%s</info>", $identifier));

        }
    }
}
