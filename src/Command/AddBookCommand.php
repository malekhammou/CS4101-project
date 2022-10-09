<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

use App\Entity\Book;
use App\Entity\Inventory;

#[AsCommand(
    name: 'app:add-book',
    description: 'Add a short description for your command',
)]
class AddBookCommand extends Command
{ /**
    * @var EntityManager : gère les fonctions liées à la persistence
    */
   private $em;

   public function __construct(ContainerInterface $container)
   {
       parent::__construct();
       $this->em = $container->get('doctrine')->getManager();
   }
    protected function configure(): void
    {
        $this
            ->addArgument('title', InputArgument::OPTIONAL, 'Book title')
            ->addArgument('author', InputArgument::OPTIONAL, 'Book author')
            ->addArgument('year', InputArgument::OPTIONAL, 'Book year')

        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $sampleInventory = new Inventory();
        $sampleInventory->setDescription("Yet another inventory");
        $this->em->persist($sampleInventory);
        $title = $input->getArgument('title');
        $author = $input->getArgument('author');
        $year = $input->getArgument('year');
        $book = new Book();
        $book->setTitle($title);
        $book->setAuthor($author);
        $book->setYear($year);
        $book->setInventory($sampleInventory);
        $this->em->persist($book);
        $this->em->flush();

        return Command::SUCCESS;
    }
}
