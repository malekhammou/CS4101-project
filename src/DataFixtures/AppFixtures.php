<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\Inventory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $book = new Book();
        $book->setTitle("Great expectations");
        $book->setAuthor("Charles Dickens");
        $book->setYear(1861);
        $inventory = new Inventory();
        $inventory->setDescription("This is a sample inventory!");
        $inventory->addBook($book);
        $book->setInventory($inventory);
        $manager->persist($book);
        $manager->persist($inventory);
        $manager->flush();
    }
}
