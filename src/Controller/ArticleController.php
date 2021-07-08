<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/article")
 * Class ArticleController
 * @package App\Controller
 */
class ArticleController extends AbstractController
{

    /**
     * @Route("/")
     * @return Response
     */
    public function index(){
        return $this->render("article/index.html.twig", []);
    }

    /**
     * @Route("/{id}", requirements={"id"="[0-9]+"})
     * @param $id
     * @return Response
     */
    public function details($id){
       return $this->render("article/details.html.twig", ["id" => $id]);
    }

    /**
     * @Route("/by-genre/{genre}")
     * @param $genre
     * @return Response
     */
    public function byGenre($genre){
        return $this->render("article/by-genre.html.twig",
            [
                "genre" => $genre
            ]
        );
    }

}