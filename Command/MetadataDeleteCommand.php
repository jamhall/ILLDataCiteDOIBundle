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
use Sensio\Bundle\GeneratorBundle\Command\Helper\DialogHelper;
use ILL\DataCiteDOIBundle\Model\Metadata;

/**
 * A command for the deletion of metadata. Please refer to the API documentation:
 * https://mds.datacite.org/static/apidoc
 * @author Mr. Jamie Hall <hall@ill.eu>
 */
class MetadataDeleteCommand extends Command
{
    protected function getDialogHelper()
    {
        $dialog = $this->getHelperSet()->get('dialog');
        if (!$dialog || get_class($dialog) !== 'Sensio\Bundle\GeneratorBundle\Command\Helper\DialogHelper') {
            $this->getHelperSet()->set($dialog = new DialogHelper());
        }

        return $dialog;
    }

    protected function configure()
    {
        $this
            ->setName('doi:metadata:delete')
            ->setDescription('Delete metadata for an identifier')
            ->addArgument(
                'identifier',
                InputArgument::REQUIRED,
                'The metadata identifier?'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getApplication()->getKernel()->getContainer();
        $identifier = $input->getArgument('identifier');
        $metadataManager = $container->get("ill_data_cite_doi.metadata_manager");
        $metadata = $metadataManager->find($identifier);
        if ($metadata) {
                $output->writeln(sprintf("Found the metadata for the identifier: <info>%s</info>", $identifier));
                $dialog = $this->getDialogHelper();
                if ($dialog->askConfirmation($output, $dialog->getQuestion('Are you sure you want to delete the metadata (you can reactivate it in the DataCite user interface)?', 'yes', '?'), true)) {
                    if ($metadataManager->delete($metadata)) {
                        $output->writeln(sprintf("Deleted metadata for the identifier: <info>%s</info>", $identifier));
                    } else {
                        $output->writeln(sprintf("Couldn't delete the metadata for the identifier: <error>%s</error>", $identifier));
                    }
                } else {
                         $output->writeln(sprintf("Aborted deletion of metadata for the identifier: <error>%s</error>", $identifier));
                }

        } else {
            $output->writeln(sprintf("Couldn't find metadata for the identifier: <error>%s</error>", $identifier));
        }
    }
}
