<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/products', name: 'api_products_')]
class ProductController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private SerializerInterface $serializer,
        private ValidatorInterface $validator
    ) {}

    #[Route('', name: 'list', methods: ['GET'])]
    public function list(ProductRepository $productRepository, Request $request): JsonResponse
    {
        $category = $request->query->get('category');
        $search = $request->query->get('search');

        if ($category) {
            $products = $productRepository->findByCategory($category);
        } elseif ($search) {
            $products = $productRepository->searchProducts($search);
        } else {
            $products = $productRepository->findActiveProducts();
        }

        $data = $this->serializer->serialize($products, 'json', ['groups' => 'product:read']);
        return JsonResponse::fromJsonString($data);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Product $product): JsonResponse
    {
        $data = $this->serializer->serialize($product, 'json', ['groups' => 'product:read']);
        return JsonResponse::fromJsonString($data);
    }

    #[Route('', name: 'create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $product = $this->serializer->deserialize(
            $request->getContent(),
            Product::class,
            'json',
            ['groups' => 'product:write']
        );

        $errors = $this->validator->validate($product);
        if (count($errors) > 0) {
            return $this->json(['errors' => (string) $errors], 400);
        }

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        $data = $this->serializer->serialize($product, 'json', ['groups' => 'product:read']);
        return JsonResponse::fromJsonString($data, 201);
    }

    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    public function update(Request $request, Product $product): JsonResponse
    {
        $this->serializer->deserialize(
            $request->getContent(),
            Product::class,
            'json',
            ['object_to_populate' => $product, 'groups' => 'product:write']
        );

        $errors = $this->validator->validate($product);
        if (count($errors) > 0) {
            return $this->json(['errors' => (string) $errors], 400);
        }

        $this->entityManager->flush();

        $data = $this->serializer->serialize($product, 'json', ['groups' => 'product:read']);
        return JsonResponse::fromJsonString($data);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(Product $product): JsonResponse
    {
        $this->entityManager->remove($product);
        $this->entityManager->flush();

        return $this->json(['message' => 'Product deleted successfully']);
    }
}