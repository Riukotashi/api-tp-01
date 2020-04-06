<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractBaseController
{

    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    
    /**
     * @Route("/category", name="category_list", methods={"GET"})
     */
    public function list(CategoryRepository $categoryRepository)
    {
        $categorys = $categoryRepository->findAll();
        return $this->json(
            ["categorys" => $categorys],
            Response::HTTP_OK,
            [],
            ["groups" => "category:detail"]
        );
    }

    /**
     * @Route("/category/{id}", name="category_get_one", methods={"GET"})
     */
    public function getOne(Category $category)
    {
        return $this->json(
            ["category" => $category],
            Response::HTTP_OK,
            [],
            [ "groups" => "category:detail"]
        );
    }

    /**
     * @Route("/category", name="category_create", methods={"POST"})
     */
    public function createCategory(Request $request)
    {
        
        $data = json_decode($request->getContent(), true);
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->submit($data);
        if ($form->isValid())
        {
            $this->em->persist($category);
            $this->em->flush();
            return $this->json(
                ["category" => $category],
                Response::HTTP_CREATED,
                [],
                [ "groups" => "category:detail"]
            );
        }

        $errors = $this->getFormErrors($form);

        return $this->json(
            $errors,
        );

    }

    /**
     * @Route("/category/{id}", name="category_delete_one", methods={"DELETE"})
     */
    public function deleteOne(Category $category)
    {
        $this->em->remove($category);
        $this->em->flush();
        return new Response(
            Response::HTTP_NO_CONTENT
        );
    }

    /**
     * @Route("/category/{id}", name="category_patch_one", methods={"PATCH"})
     */
    public function patch(Category $category, Request $request)
    {
        return $this->update($category, $request, false);
    }

    /**
     * @Route("/category/{id}", name="category_put_one", methods={"PUT"})
     */
    public function put(Category $category, Request $request)
    {
        return $this->update($category, $request);
    }


    /**
     * @Route("/category/{id}/article", name="category_get_articles", methods={"GET"})
     */
    public function categoryArticle(Category $category)
    {
        $articles = $category->getArticles() ;
        return $this->json(
            ["articles" => $articles],
            Response::HTTP_OK,
            [],
            ["groups" => "article:detail"]
        );
    }


    private function update(
        Category $category,
        Request $request,
        bool $clearMissing = true
        )
    {
        $data = json_decode($request->getContent(), true);
        $form = $this->createForm(CategoryType::class, $category);
        $form->submit($data, $clearMissing);

        if ($form->isValid())
        {
            $this->em->flush();
            return $this->json(
                ["category" => $category],
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
