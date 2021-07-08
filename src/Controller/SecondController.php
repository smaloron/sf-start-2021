<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecondController extends AbstractController
{

    /**
     * @Route ("/second/{num1}",
     *     name="addition",
     *     defaults={"num1"=1},
     *     requirements={"num1"="[0-9]+"}
     * )
     * @param $num1
     * @return Response
     */
    public function addition($num1){
        $result = "Le résultat est ". ($num1 + 5);
        return $this->render(
            "addition.html.twig",
            [
                "calcul" => $result,
                "fruitList" => ["Pommes", "Oranges", "Groseilles"],
                "person" => ["name" => "Brahé", "firstName" => "Tycho"]
            ]
        );
    }

    /**
     * @Route ("/second/{name}", name="bonjour" , defaults={"name"="Toto"})
     * @return Response
     */
    public function index($name){
        return new Response("Bonjour $name");
    }

}