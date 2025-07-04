<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/orders', name: 'api_orders_')]
class OrderController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private SerializerInterface $serializer,
        private ValidatorInterface $validator
    ) {}

    #[Route('', name: 'list', methods: ['GET'])]
    public function list(OrderRepository $orderRepository): JsonResponse
    {
        $user = $this->getUser();
        $orders = $orderRepository->findByUser($user);

        $data = $this->serializer->serialize($orders, 'json', ['groups' => 'order:read']);
        return JsonResponse::fromJsonString($data);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Order $order): JsonResponse
    {
        $this->denyAccessUnlessGranted('view', $order);

        $data = $this->serializer->serialize($order, 'json', ['groups' => 'order:read']);
        return JsonResponse::fromJsonString($data);
    }

    #[Route('', name: 'create', methods: ['POST'])]
    public function create(Request $request, ProductRepository $productRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        
        $order = new Order();
        $order->setUser($this->getUser());

        foreach ($data['items'] as $itemData) {
            $product = $productRepository->find($itemData['productId']);
            if (!$product) {
                return $this->json(['error' => 'Product not found'], 404);
            }

            if ($product->getStock() < $itemData['quantity']) {
                return $this->json(['error' => 'Insufficient stock'], 400);
            }

            $orderItem = new OrderItem();
            $orderItem->setProduct($product);
            $orderItem->setQuantity($itemData['quantity']);
            $orderItem->setPrice($product->getPrice());
            $order->addOrderItem($orderItem);

            // Update stock
            $product->setStock($product->getStock() - $itemData['quantity']);
        }

        $order->calculateTotalAmount();

        $errors = $this->validator->validate($order);
        if (count($errors) > 0) {
            return $this->json(['errors' => (string) $errors], 400);
        }

        $this->entityManager->persist($order);
        $this->entityManager->flush();

        $data = $this->serializer->serialize($order, 'json', ['groups' => 'order:read']);
        return JsonResponse::fromJsonString($data, 201);
    }

    #[Route('/{id}/status', name: 'update_status', methods: ['PATCH'])]
    public function updateStatus(Request $request, Order $order): JsonResponse
    {
        $this->denyAccessUnlessGranted('edit', $order);

        $data = json_decode($request->getContent(), true);
        $order->setStatus($data['status']);

        $errors = $this->validator->validate($order);
        if (count($errors) > 0) {
            return $this->json(['errors' => (string) $errors], 400);
        }

        $this->entityManager->flush();

        $data = $this->serializer->serialize($order, 'json', ['groups' => 'order:read']);
        return JsonResponse::fromJsonString($data);
    }
}