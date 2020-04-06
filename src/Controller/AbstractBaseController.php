<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;

abstract class AbstractBaseController extends AbstractController 
{
    protected function getFormErrors(FormInterface $form): array
    {
        $errors = [];
        $formErrors = $form->getErrors(true);

        foreach ($formErrors as $error) {
            $field = $error->getOrigin()->getName();
            $message = $error->getMessage();

            $errors[$field] = $message;
        }

        return $errors;
    }

    protected function update(
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
