<?php
declare(strict_types=1);
namespace WebShoppingApp\Model;

use WebShoppingApp\View\ProductHtmlOutput;
use WebShoppingApp\View\ListableItem;

class Product extends ListableItem
{
    private string $id;
    private string $name;
    private string $description;
    private float $price;
    private int $quantity;
    private int $visibility = 1;

    public function __construct(string $id, string $name,
                                string $description, float $price,
                                int $quantity)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function price(): float
    {
        return $this->price;
    }

    public function quantity(): int
    {
        return $this->quantity;
    }

    public function visibility(): int
    {
        return $this->visibility;
    }

    public function hideItem(): void
    {
         if ($this->visibility > 0 ) $this->visibility = 0;
    }

    public function clearQuantity(): void
    {
        $this->quantity = 0;
    }

    public function incrementQuantity(): void
    {
        $this->quantity++;
    }

    public function deductBy(Product $prod): int|false
    {
        if (($this->quantity - $prod->quantity()) >= 0){
            $this->quantity = $this->quantity - $prod->quantity();
            return $this->quantity;
        }
        return false;
    }

    public function render(): string|null
    {
        return (new ProductHtmlOutput($this))->toTableRowView();
    }

    public function __toString(): string
    {
        return "[{$this->id()}]|  {$this->name()}: {$this->description()}|  &dollar;{$this->price()}|   Qty: {$this->quantity()}| ";
    }
}
