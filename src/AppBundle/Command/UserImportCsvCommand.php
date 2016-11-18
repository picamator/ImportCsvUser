<?php
declare(strict_types = 1);

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class UserImportCsvCommand extends ContainerAwareCommand
{
    /**
     * Configure
     *
     * @codeCoverageIgnore
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('user:import-csv')
            ->setDescription('Import user\'s file in csv format to database')
            ->addOption('path', null, InputOption::VALUE_REQUIRED, 'Path to csv file');
    }

    /**
     * Execute
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $path = $input->getOption('path');

        /** @var \AppBundle\Model\Api\Data\PathInterface $path */
        $path = $this->getContainer()->get('csv_builder_path_factory')->create($path);

        /** @var \AppBundle\Service\ImportCsvUser $importCsvUser */
        $importCsvUser  = $this->getContainer()->get('service_import_csv_user');
        $importResult   = $importCsvUser->import($path);

        // display results
        $outputMsg = [
            sprintf('<info>Imported: %s</info>', $importResult->getImported()),
            sprintf('<comment>Skipped: %s</comment>', $importResult->getSkipped())
        ];
        foreach($importResult->getErrorList() as $item) {
            $outputMsg[] = sprintf('<error>%s</error>', $item);
        }

        $output->writeln($outputMsg);
    }
}
