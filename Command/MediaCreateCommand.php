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
use ILL\DataCiteDOIBundle\Model\Media;

/**
 * @author Mr. Jamie Hall <hall@ill.eu>
 */
class MediaCreateCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('doi:media:create')
            ->setDescription('Create media for a DOI')
            ->addArgument(
                'id',
                InputArgument::REQUIRED,
                'The DOI id?'
            )
            ->addArgument(
                'mimeType',
                InputArgument::REQUIRED,
                'The mime type for the media?'
            )
            ->addArgument(
                'url',
                InputArgument::REQUIRED,
                'The url for the media?'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getApplication()->getKernel()->getContainer();
        $doiManager = $container->get("ill_data_cite_doi.manager");
        $id = $input->getArgument('id');
        $doi = $doiManager->find($id);
        if ($doi) {
            $output->writeln(sprintf("The DOI with the identifier of <info>%s</info> was found", $doi->getIdentifier()));
            $mediaManager = $container->get("ill_data_cite_doi.media_manager");
            // create the media object
            $media = new Media();
            $media->setMimeType($input->getArgument('mimeType'))
                  ->setUrl($input->getArgument('url'));
            $mediaManager->create($doi, $media);

        } else {
            $output->writeln(sprintf("Couldn't find DOI with the identifier of: <error>%s</error>", $id));
        }
    }
}
