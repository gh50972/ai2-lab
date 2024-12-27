<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Service\WeatherUtil;

#[AsCommand(
    name: 'weather:city',
    description: 'Add a short description for your command',
)]
class WeatherCityCommand extends Command
{
    public function __construct(private readonly WeatherUtil $weatherUtil)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('countryCode', InputArgument::OPTIONAL, 'Country code')
            ->addArgument('cityName', InputArgument::OPTIONAL, 'City name');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $locationRepository = $this->weatherUtil->getLocationRepository();
        $io = new SymfonyStyle($input, $output);
        $countryCode = $input->getArgument('countryCode');
        $cityName = $input->getArgument('cityName');

        $location = $locationRepository->findByCountryCodeAndName($countryCode, $cityName);
        $measurements = $this->weatherUtil->getWeatherForLocation($location);
        $io->writeln(sprintf('Location: %s', $location->getCity()));

        foreach ($measurements as $measurement) {
            $io->writeln(sprintf("\t%s: %s",
                $measurement->getDateTime()->format('Y-m-d H:i:s'),
                $measurement->getCelsius()
            ));
        }

        return Command::SUCCESS;
    }
}
