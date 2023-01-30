<?php
declare(strict_types=1);

namespace WebShoppingApp\Model;

class Cart
{

    /** @var Product[]  */
    protected array $products = [];
    private int $visibility = 1;

    public function __construct(?Product $product = null)
    {
        if (isset($product)) $this->addProduct($product);
    }

    public function addProduct(Product $product): void
    {
        $this->products[] = $product;
    }

    public function itemsCount(): int
    {
        return count($this->products);
    }

    public function visibility(): int
    {
        return $this->visibility;
    }

    public function hideItem(): void
    {
        if ($this->visibility() > 0 ) $this->visibility = 0;
    }

    /** @return Product[] */
    public function fetchAll(): array
    {
        return $this->products;
    }

    public function total(): float
    {
        $total = 0.0;
        foreach ($this->products as $p) {
            $total += ($p->quantity() * $p->price());
        }
        return $total;
    }

    public function __toString(): string
    {
        return 'The cart contains ' . $this->itemsCount() . ' items' . PHP_EOL;
    }
}