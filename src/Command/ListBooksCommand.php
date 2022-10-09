<?php

namespace App\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use App\Entity\Book;
use App\Repository\BookRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;

#[AsCommand(
    name: 'app:list-books',
    description: 'List all books',
)]
class ListBooksCommand extends Command
{
 /**
     * @var BookRepository
     */
    private $bookRepository;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->bookRepository = $container->get('doctrine')->getManager()->getRepository(Book::class);
    }
    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $books = $this->bookRepository->findAll();
    if(!$books) {
        $output->writeln('<comment>no books found<comment>');
        exit(1);
    }

    foreach($books as $book)
    {
        $output->writeln($book);
    }

    return Command::SUCCESS;
    }
}
