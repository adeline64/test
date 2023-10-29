<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api')]
class HomeController extends AbstractController
{

    #[Route('/', name: 'home', methods: ['GET'])]
    public function index(Request $request, CategoryRepository $categoryRepo, SessionInterface $session, ProductRepository $productRepository): JsonResponse
    {

        $filter = $request->get("filter");
        $minRange = $productRepository->findOneBy([], ['price' => 'asc'])->getPrice();
        $maxRange = $productRepository->findOneBy([], ['price' => 'desc'])->getPrice();

        if ($request->get("minPrice")) {
            $minChoice = $request->get("minPrice") * 100;
        } else {
            $minChoice = $minRange;
        }

        if ($request->get("maxPrice")) {
            $maxChoice = $request->get("maxPrice") * 100;
        } else {
            $maxChoice = $maxRange;
        }

        $categories = $categoryRepo->findAll();
        $categoriesChoice = $request->get("category", []);
        $products = $productRepository->findAllByFilters($filter, $minChoice, $maxChoice, $categoriesChoice);

        // Prepare the data you want to return
        $responseData = [
            "products" => $products,
            "categories" => $categories,
            "minRange" => $minRange,
            "maxRange" => $maxRange,
            "minChoice" => $minChoice,
            "maxChoice" => $maxChoice,
        ];

        return $this->json($responseData);
    }
}