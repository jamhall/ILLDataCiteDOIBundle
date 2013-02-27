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

/**
 * @author Jamie Hall <hall@ill.eu>
 */
class DOIFindCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('doi:find')
            ->setDescription('Find a DOI')
            ->addArgument(
                'id',
                InputArgument::REQUIRED,
                'The DOI id?'
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
            $output->writeln(sprintf("The identifier of <info>%s</info> has the URL of <info>%s</info>", $doi->getIdentifier(), $doi->getUrl()));
            $output->writeln($doi->getMetadata());
        } else {
            $output->writeln(sprintf("Couldn't find DOI with the identifier of: <error>%s</error>", $id));
        }
    }
}
