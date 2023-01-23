<?php
declare(strict_types=1);

namespace WebShoppingApp\Model;
use WebShoppingApp\DataFlow\InputData;
use WebShoppingApp\Model\Product;

class Cart
{

    /** @var Product[]  */
    private array $products;
    private int $visibility = 1;

    public function __construct(?Product $product = null)
    {
        if (isset($product))
        $this->addProduct($product);
    }

    public function addProduct(Product $product): void
    {
        $this->products[] = $product;
    }

    public function orderId(): string
    {
        return $this->orderId;
    }

    public function visibility(): int
    {
        return $this->visibility;
    }

    public function hideItem(): void
    {
        if ($this->visibility() > 0 ) $this->visibility = 0;
    }
}