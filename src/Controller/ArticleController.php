<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractBaseController
{

    private $em;
    private $articleRepository;
    public function __construct(EntityManagerInterface $em, ArticleRepository $articleRepository)
    {
        $this->em = $em;
        $this->articleRepository = $articleRepository;
    }
    
    /**
     * @Route("/article", name="article_list", methods={"GET"})
     */
    public function list()
    {
        $articles = $this->articleRepository->findAll();
        return $this->json(
            ["articles" => $articles],
            Response::HTTP_OK,
            [],
            ["groups" => "article:detail"]
        );
    }

    /**
     * @Route("/article/{id}", name="article_get_one", methods={"GET"})
     */
    public function getOne(Article $article)
    {
        return $this->json(
            ["article" => $article],
            Response::HTTP_OK,
            [],
            [ "groups" => "article:detail"]
        );
    }

    /**
     * @Route("/article", name="article_create", methods={"POST"})
     */
    public function createArticle(Request $request)
    {
        
        $data = json_decode($request->getContent(), true);
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->submit($data);
        if ($form->isValid())
        {
            $this->em->persist($article);
            $this->em->flush();
            return $this->json(
                ["article" => $article],
                Response::HTTP_CREATED,
                [],
                [ "groups" => "article:detail"]
            );
        }

        $errors = $this->getFormErrors($form);

        return $this->json(
            $errors,
        );

    }

    /**
     * @Route("/article/{id}", name="article_delete_one", methods={"DELETE"})
     */
    public function deleteOne(Article $article)
    {
        $this->em->remove($article);
        $this->em->flush();
        return new Response(
            Response::HTTP_NO_CONTENT
        );
    }

    

    /**
     * @Route("/article/{id}", name="article_patch_one", methods={"PATCH"})
     */
    public function patch(Article $article, Request $request)
    {
        return $this->update($article, $request, false);
    }

    /**
     * @Route("/article/{id}", name="article_put_one", methods={"PUT"})
     */
    public function put(Article $article, Request $request)
    {
        return $this->update($article, $request);
    }

    /**
     * @Route("/trending/article", name="article_list_trending", methods={"GET"})
     */
    public function listTrending()
    {
        $articles = $this->articleRepository->findBy(array('trending' => true));
        // $articles = $articleRepository->findAll();
        return $this->json(
            ["articles" => $articles],
            Response::HTTP_OK,
            [],
            ["groups" => "article:detail"]
        );
    }


    private function update(
        Article $article,
        Request $request,
        bool $clearMissing = true
        )
    {
        $data = json_decode($request->getContent(), true);
        $form = $this->createForm(ArticleType::class, $article);
        $form->submit($data, $clearMissing);

        if ($form->isValid())
        {
            $this->em->flush();
            return $this->json(
                ["article" => $article],
                Response::HTTP_OK,
                [],
                [ "groups" => "article:detail"]
            );
        }

        $errors = $this->getFormErrors($form);

        return $this->json(
            $errors,
        );
    }


}
