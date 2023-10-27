<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class CategoryController extends AbstractController
{

    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    #[Route('/categories', name: 'api_categories_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $categories = $this->categoryRepository->findAll();
        $categoryData = [];

        foreach ($categories as $category) {
            $categoryData[] = [
                'id' => $category->getId(),
                'name' => $category->getName(),
                'description' => $category->getDescription(),
                'slug' => $category->getSlug(),
            ];
        }

        return $this->json($categoryData);
    }

    #[Route('/categories/{id}', name: 'api_categories_show', methods: ['GET'])]
    public function show(Category $category): JsonResponse
    {
        $categoryData = [
            'id' => $category->getId(),
            'name' => $category->getName(),
            'description' => $category->getDescription(),
            'slug' => $category->getSlug(),
        ];

        return $this->json($categoryData);
    }

    #[Route('/categories', name: 'api_categories_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // You would typically validate and sanitize the input data here.

        $category = new Category();
        $category->setName($data['name']);
        $category->setDescription($data['description']);
        $category->setSlug($data['slug']);

        // Persist the category to the database (you might want to wrap this in a try-catch block for error handling).

        return $this->json(['message' => 'Category created'], 201);
    }

    #[Route('/categories/{id}', name: 'api_categories_update', methods: ['PUT'])]
    public function update(Category $category, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // You would typically validate and sanitize the input data here.

        $category->setName($data['name']);
        $category->setDescription($data['description']);
        $category->setSlug($data['slug']);

        // Persist the updated category to the database (you might want to wrap this in a try-catch block for error handling).

        return $this->json(['message' => 'Category updated']);
    }

    #[Route('/categories/{id}', name: 'api_categories_delete', methods: ['DELETE'])]
    public function delete(Category $category): JsonResponse
    {
        // Delete the category from the database (you might want to wrap this in a try-catch block for error handling).

        return $this->json(['message' => 'Category deleted']);
    }

}
