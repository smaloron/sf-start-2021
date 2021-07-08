<?php


namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;

class FirstController
{

    public function index(): Response{
        return new Response("Tout fonctionne bien");
    }

    public function hello(string $name): Response {
        return new Response("Hello $name");
    }

}