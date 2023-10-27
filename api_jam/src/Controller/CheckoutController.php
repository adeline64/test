<?php

namespace App\Controller;

use App\Entity\LineOrder;
use App\Entity\Order;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse; // Make sure to import JsonResponse

#[Route('/api')]
class CheckoutController extends AbstractController
{

    private $session;
    private $productRepo;
    private $orderRepo;
    private $manager;

    public function __construct(SessionInterface $session, ProductRepository $productRepo, OrderRepository $orderRepo, EntityManagerInterface $manager)
    {
        $this->session = $session;
        $this->productRepo = $productRepo;
        $this->orderRepo = $orderRepo;
        $this->manager = $manager;
    }

    #[IsGranted("ROLE_USER")]
    #[Route('checkout_success/{token}', name: 'checkout_success',  methods: ['GET'])]
    public function checkoutSuccess(string $token): JsonResponse
    {
        if ($this->isCsrfTokenValid('stripe_token', $token)) {
            $orderId = $this->session->get("order_waiting");
            $order = $this->orderRepo->find($orderId);

            if ($order) {
                $order->setStatus("PAYMENT_OK");
                $this->manager->flush();

                return $this->json(['message' => 'Payment successful', 'order' => $order]);
            }
        }

        return $this->json(['error' => 'Invalid CSRF token'], 400);

    }

    #[IsGranted("ROLE_USER")]
    #[Route('/checkout_error', name: 'checkout_error', methods: ['GET'])]
    public function error(): JsonResponse
    {
        return $this->json(['error' => 'Payment error'], 400);

    }

    #[IsGranted("ROLE_USER")]
    #[Route('/checkout', name: 'checkout', methods: ['POST'])]
    public function index(): JsonResponse
    {
        $stripe_items = [];
        $cart = $this->session->get("cart", []);

        if (empty($cart)) {
            return $this->json(['error' => 'Cart is empty'], 400);
        }

        $order = new Order;
        $order->setDatetime(new DateTime);
        $order->setStatus("PAYMENT_WAITING");
        $total = 0;

        foreach ($cart as $key => $quantity) {
            $product = $this->productRepo->find($key);

            if ($product) {
                $line = new LineOrder;
                $line->setProduct($product);
                $line->setQuantity($quantity);
                $line->setSubtotal($quantity * $product->getPrice());
                $total += $quantity * $product->getPrice();
                $order->addLineOrder($line);
                $stripe_items[] = [
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => $product->getName(),
                        ],
                        'unit_amount' => $product->getPrice(),
                    ],
                    'quantity' => $quantity,
                ];
            }
        }

        $order->setTotal($total);
        $this->manager->persist($order);
        $this->manager->flush();
        $this->session->set("order_waiting", $order->getId());

        \Stripe\Stripe::setApiKey($_ENV["STRIPE_API_KEY"]);
        $session = \Stripe\Checkout\Session::create([
            'line_items' => $stripe_items,
            'mode' => 'payment'
        ]);

        return $this->json(['message' => 'Checkout initiated', 'checkout_url' => $session->url]);
    }
}
