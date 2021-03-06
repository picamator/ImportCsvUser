<?php
declare(strict_types = 1);

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UserAgeAverageCommand extends ContainerAwareCommand
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
        $this->setName('user:age-average')
            ->setDescription('Calculate average age with male & female distribution');
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
        /** @var \AppBundle\Service\AgeStatistics $service */
        $service = $this->getContainer()->get('service_age_average');

        // display results
        $outputMsg = [
            sprintf('<info>Average male age: %s</info>', $service->getAverageAge('m')),
            sprintf('<info>Average female age: %s</info>', $service->getAverageAge('f'))
        ];

        $output->writeln($outputMsg);
    }
}
