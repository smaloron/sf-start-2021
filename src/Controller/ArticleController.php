<?php


namespace App\Controller;


use App\Entity\Article;

use App\Entity\Comment;
use App\Form\ArticleFormType;
use App\Form\CommentFormType;
use App\Repository\ArticleRepository;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/article")
 * Class ArticleController
 * @package App\Controller
 */
class ArticleController extends AbstractController
{

    /**
     * @Route("/", name="article_index")
     * @return Response
     */
    public function index(ArticleRepository $repository)
    {
        $data = $repository->findAll();

        return $this->render(
            "article/index.html.twig",
            [
                "articleList" => $data,
                "title" => "Liste de tous les articles"
            ]
        );
    }

    /**
     * @Route("/{id}", requirements={"id"="[0-9]+"}, name="article_details")
     * @param $id
     * @return Response
     */
    public function details(
        Article $article,
        Request $request,
        EntityManagerInterface $em)
    {
        if(empty($article)){
            // Alternative : lever une exception personnalisée
            // throw $this->createNotFoundException("L'article demandé n'existe pas");

            // Création d'un message qui sera affiché dans la prochaine requête
            $this->addFlash("error", "L'article demandé n'existe pas");
            // Redirection vers la liste des livres
            return $this->redirectToRoute("article_index");
        }

        // Création d'une instance de Comment
        $comment = new Comment();
        $comment->setArticle($article);

        // création du formulaire
        $form = $this->createForm(
            CommentFormType::class,
            $comment
        );

        // Traitement du formulaire
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            //$em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            //Redirection
            return  $this->redirectToRoute(
                "article_details",
                ["id" => $article->getId()]
            );
        }

        return $this->render(
            "article/details.html.twig",
            [
                "article" => $article,
                "commentForm" => $form->createView()
            ]
        );
    }

    /**
     * @Route("/by-genre/{genre}", name="article_by_genre")
     * @param $genre
     * @return Response
     */
    public function byGenre($genre, ArticleRepository $repository)
    {
        $data = $repository->findBy(["genre" => $genre]);
        return $this->render(
            "article/index.html.twig",
            [
                "genre" => $genre,
                "articleList" => $data,
                "title" => "Articles parlant de : $genre"
            ]
        );
    }

    /**
     * @Route ("/delete/{id}",
     *     name="article_delete",
     *     requirements={"id":"\d+"}
     * )
     * @param $id
     */
    public function delete(
        $id,
        ArticleRepository $repository,
        EntityManagerInterface $manager
    ){

        // Vérification des autorisations
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $article = $repository->findOneBy(["id" => $id]);
        if($article){
            $manager->remove($article);
            $manager->flush();
            $this->addFlash("success","Votre article est supprimé" );
        } else {
            $this->addFlash("error", "L'article n'existe pas");
        }

        return $this->redirectToRoute("article_index");
    }

    /**
     * @Route("/form", name="article_new_form")
     * @Route("/update/{id}", name="article_update")
     */
    public function form(
        Request $request,
        EntityManagerInterface $manager,
        ArticleRepository $repository,
        int $id= null
    ){
        // Instance de l'entité Article
        if($id === null){
            $article = new Article();
        } else {
            $article = $repository->findOneBy(["id" => $id]);
        }

        dump($article);

        // Création du formulaire
        $form = $this->createForm(
            ArticleFormType::class,
            $article,
            []
        );
        // Traitement du formulaire
        // qui récupére les données de la requête
        $form->handleRequest($request);

        // Test de validité du formulaire
        if($form->isSubmitted() && $form->isValid()){
            // Enregistrement dans la BD
            $manager->persist($article);
            $manager->flush();
            // Message flash
            $this->addFlash("success", "L'article a bien été enregistré");
            //redirection
            return $this->redirectToRoute("article_index");
        }

        // Affichage de la vue
        return $this->render("article/form.html.twig", [
            "articleForm" => $form->createView()
        ]);

    }

    /**
     * @Route("/by-author/{slug}", name="article_by_author")
     * @param $slug
     */
    public  function byAuthor(string $slug, AuthorRepository $repository){
        // Récupération de l'auteur
        $author = $repository->findOneBy(["slug" => $slug]);

        // Gestion d'un auteur non trouvé
        if($author === null){
            throw $this->createNotFoundException("Auteur non trouvé");
        }

        return $this->render("article/index.html.twig", [
            "title" => "Liste des articles de "
                        . $author->getFirstName() . " "
                        . $author->getName(),
            "articleList" => $author->getArticles()
        ]);
    }

}