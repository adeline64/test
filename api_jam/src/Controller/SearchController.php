<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    
    #[Route('/search', name: 'search', methods: ['GET'])]
    public function search(ProductRepository $productRepository, Request $request): JsonResponse
    {
        $searchTerm = $request->query->get("search");
        $products = $productRepository->findAllLike($searchTerm);

        $productData = [];

        foreach ($products as $product) {
            // Ajoutez les données du produit que vous souhaitez exposer dans la réponse JSON
            $productData[] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'description' => $product->getDescription(),
                'price' => $product->getPrice(),
                'image' => $product->getImage(),
            ];
        }

        return $this->json(['products' => $productData]);
    }

    #[Route('/search/{name}', name: 'search', methods: ['GET'])]
    public function searchName(ProductRepository $productRepository, string $name): JsonResponse
    {
        $products = $productRepository->findAllLike($name);

        $productData = [];

        foreach ($products as $product) {
            // Ajoutez les données du produit que vous souhaitez exposer dans la réponse JSON
            $productData[] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'description' => $product->getDescription(),
                'price' => $product->getPrice(),
                'image' => $product->getImage(),
            ];
        }

        return $this->json(['products' => $productData]);
    }

  
    
}