<?php

namespace App\DataFixtures;

use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AuthorFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $author = new Author();
        $author->setFirstName("Victor")->setName("Hugo");
        $manager->persist($author);
        $this->addReference("author1", $author);

        $author = new Author();
        $author->setFirstName("Patrice")->setName("Arfi");
        $manager->persist($author);
        $this->addReference("author2", $author);

        $author = new Author();
        $author->setFirstName("Edwy")->setName("Plenel");
        $manager->persist($author);
        $this->addReference("author3", $author);

        $author = new Author();
        $author->setFirstName("Ernest")->setName("Hemingway");
        $manager->persist($author);
        $this->addReference("author4", $author);

        $manager->flush();
    }
}
