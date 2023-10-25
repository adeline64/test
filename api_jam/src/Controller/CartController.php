<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Service\Cart;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class CartController extends AbstractController
{
    #[Route('/cart', name: 'cart')]
    public function index(Cart $cartSession, ProductRepository $productRepo): JsonResponse
    {
        $cart = [];
        foreach ($cartSession->getCart() as $id => $quantity) {
            if ($quantity > 0) {
                $product = $productRepo->find($id);
                if ($product) {
                    $cart[] = [
                        'id' => $product->getId(),
                        'name' => $product->getName(),
                        'quantity' => $quantity,
                    ];
                }
            }
        }
        return new JsonResponse($cart);
    }

    #[Route('/addCart/{id}', name: 'addCart')]
    public function addCart(Cart $cart, Request $request, Product $product): JsonResponse
    {
        $quantity = $request->get("quantity");
        $cart->update($product, $quantity);

        return new JsonResponse(['message' => 'Item added to the cart']);
    }

    #[Route('/cartsize', name: 'cartsize')]
    public function getCartSize(Cart $cart): JsonResponse
    {
        $totalQuantity = $cart->getTotalQuantity();

        return new JsonResponse(['cart_size' => $totalQuantity]);
    }
  
}






