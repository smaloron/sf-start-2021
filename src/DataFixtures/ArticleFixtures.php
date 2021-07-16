<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $numberOfArticles = 50;
        $faker = Factory::create();

        $genresList = [
            "Politique",
            "Economie",
            "People",
            "Sport",
            "Informatique"
        ];

        for ($i = 1; $i <= $numberOfArticles; $i++) {
            $article = new Article();
            $article->setTitle($faker->words(3, true))
                ->setGenre($genresList[array_rand($genresList)])
                ->setContent($faker->words(200, true))
                ->setCreatedAt(
                    \DateTimeImmutable::createFromMutable(
                        $faker->dateTimeBetween('-18 months', 'now')
                    )
                )
                ->setAuthor(
                    $this->getReference("author". mt_rand(1, 4))
                );

                // Génération d'un tag aléatoire
                $tagList = TagFixtures::$tags;
                $randomReference = array_rand($tagList);
                $tag = $this->getReference($tagList[$randomReference]);
                $article->addTag($tag);

            $manager->persist($article);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            AuthorFixtures::class
        ];
    }
}
