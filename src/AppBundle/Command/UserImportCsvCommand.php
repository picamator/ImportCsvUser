<?php

namespace AppBundle\Command;

use AppBundle\Model\Api\Csv\ReaderFilterIteratorInterface;
use AppBundle\Model\ImportCsvUser;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class UserImportCsvCommand extends ContainerAwareCommand
{
    /**
     * Configure
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
        // validate file
        $path = $input->getOption('path');
        if (!file_exists($path) || !is_readable($path)) {
            $output->writeln(
                sprintf('Can not make import. Invalid path "%s". Failed does not exist or does not have readable permission. Please check your file and try again.', $path)
            );
            return;
        }

        // validate extension
        $info = new \SplFileInfo($path);
        if($info->getExtension() !== 'csv') {
            $output->writeln(
                sprintf('Can not make import. Invalid file extension "%s". Please use .csv files for import.', $info->getExtension())
            );
            return;
        }

        // import
        $container = $this->getContainer();

        /** @var ReaderFilterIteratorInterface $readerFilterIteration */
        $readerFilterIteration = $container->get('csv_builder_reader_iteration_factory')
            ->create($path);

        /** @var ImportCsvUser $importCsvUser */
        $importCsvUser  = $container->get('import_csv_user');
        $importResult   = $importCsvUser->import($readerFilterIteration);

        // display results
        $output->writeln('Imported: ' . $importResult->getImported());
        $output->writeln('Skipped: ' . $importResult->getSkipped());
        foreach($importResult->getErrorList() as $item) {
            $output->writeln($item);
        }
    }
}
