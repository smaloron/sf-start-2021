<?php

namespace App\Controller;

use App\Entity\Article;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DoctrineTestController extends AbstractController
{
    /**
     * @Route("/doctrine-test")
     * @return Response
     */
    public function index(): Response
    {
        //instance de Faker
        $faker = Factory::create();


        // création d'un article
        $article = new Article();
        $article->setTitle($faker->words(3, true))
                ->setContent($faker->words(200, true))
                ->setCreatedAt(
                    \DateTimeImmutable::createFromMutable(
                        $faker->dateTimeBetween('-18 months', 'now')
                    )
                );

        // sauvegarde de l'article dans la BD

        // récupération du manager instance de EntityManager
        $manager = $this->getDoctrine()->getManager();
        // marque l'entité article pour la persistance
        $manager->persist($article);

        // Exécution effective de la requête SQL
        $manager->flush();



        return $this->render('doctrine_test/index.html.twig', [
            "article" => $article
        ]);
    }
}
