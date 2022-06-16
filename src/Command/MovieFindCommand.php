<?php

namespace App\Command;

use App\Consumer\OMDbApiConsumer;
use App\Provider\MovieProvider;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class MovieFindCommand extends Command
{
    protected static $defaultName = 'app:movie:find';
    protected static $defaultDescription = 'Find a movie by title or OMDb ID';

    private MovieProvider $provider;

    public function __construct(MovieProvider $provider, string $name = null)
    {
        $this->provider = $provider;
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->addArgument('type', InputArgument::OPTIONAL, 'The type of search, "title" or "id"')
            ->addArgument('value', InputArgument::OPTIONAL, 'The title or ID to search.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $type = $input->getArgument('type');
        while (!in_array($type, ['id', 'title'])) {
            $type = $io->ask('What is the type of the data used for the search? ("title" or "id")');
        }

        $value = $input->getArgument('value');
        while (empty($value)) {
            $value = $io->ask(sprintf('What is the %s you want to search?', $type));
        }

        $io->text(sprintf("Looking for a movie with %s %s", $type, $value));

        try {
            $method = "getBy" . ucfirst($type);
            $movie = $this->provider->$method($value);
        } catch (\Exception $e) {
            $io->error('No movie found.');

            return Command::FAILURE;
        }

        $io->success('Found a movie!');
        $io->table(['Id', 'OMDb ID', 'title', 'Rated'], [
            [$movie->getId(), $movie->getOmdbId(), $movie->getTitle(), $movie->getRated()],
        ]);

        return Command::SUCCESS;
    }
}
