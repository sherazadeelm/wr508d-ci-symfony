<?php

namespace App\Service;

use App\Entity\Product;

final class InventoryService
{
    /** @var array<int, int> */
    private array $stock = [];

    /**
     * @param list<Product> $products
     */
    public function __construct(array $products = [])
    {
        foreach ($products as $product) {
            $this->stock[$product->getId()] = $product->getStock();
        }
    }

    public function sell(Product $product, int $quantity): void
    {
        if ($quantity < 0) {
            throw new \InvalidArgumentException('La quantité ne peut pas être négative.');
        }

        $id = $product->getId();
        $currentStock = $this->stock[$id] ?? 0;

        if ($quantity > $currentStock) {
            throw new \InvalidArgumentException('Stock insuffisant.');
        }

        $this->stock[$id] -= $quantity;
    }

    public function restock(Product $product, int $quantity): void
    {
        $this->stock[$product->getId()] += $quantity;
    }

    public function stockOf(Product $product): int
    {
        return $this->stock[$product->getId()] ?? 0;
    }
}
