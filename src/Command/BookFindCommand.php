<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class BookFindCommand extends Command
{
    protected static $defaultName = 'app:book:find';
    protected static $defaultDescription = 'Add a short description for your command';

    protected function configure(): void
    {
        $this
            ->setName('app:book:find')
            ->setAliases(['book:find'])
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addArgument('arg2', InputArgument::IS_ARRAY|InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', '1', InputOption::VALUE_NONE, 'Option description')
            ->addOption('option2', '2', InputOption::VALUE_NEGATABLE, 'Option description')
            ->addOption('option3', '3', InputOption::VALUE_REQUIRED, 'Option description')
            ->addOption('option4', '4', InputOption::VALUE_IS_ARRAY|InputOption::VALUE_REQUIRED, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');
        $arg2 = $input->getArgument('arg2');

        if ($arg1) {
            $io->note(sprintf('You passed a first argument: %s', $arg1));
        }

        if ($arg2) {
            $io->note(sprintf('You passed a second argument: %s', implode(', ', $arg2)));
        }

        if ($input->getOption('option1')) {
            $io->note('You passed an option');
        }
        if ($input->getOption('option2')) {
            $io->note('You passed an option');
        } elseif (false === $input->getOption('option2')) {
            $io->note('You passed a no option');
        }
        if ($opt = $input->getOption('option3')) {
            $io->note(sprintf('You passed an option: %s', $opt));
        }
        if ($opt4 = $input->getOption('option4')) {
            $io->note(sprintf('You passed an option: %s', implode(', ', $opt4)));
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
