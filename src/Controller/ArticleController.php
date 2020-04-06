<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article", name="article_list", methods={"GET"})
     */
    public function list(ArticleRepository $articleRepository)
    {
        $articles = $articleRepository->findAll();
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
}
