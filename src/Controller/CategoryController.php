<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    //Constructeur liste de toutes les catégories
    #[Route('/categories', name: 'categories_list_cat')]
    public function list(CategoryRepository $categories): Response
    {
        $categories = $categories->findAll();

        return $this->render(
            'category/listcat.html.twig',
            ['categories' => $categories]
        );
    }

    //Constructeur catégories par ID 
    #[Route('/category/{id}', name: 'category_item')]
    public function item(Category $category): Response
    {
        return $this->render(
            'category/item.html.twig',
            ['category' => $category]
        );
    }
}
