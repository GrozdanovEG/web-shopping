<?php
declare(strict_types=1);
namespace WebShoppingApp\Model;

use WebShoppingApp\View\HtmlOutput;
use WebShoppingApp\View\ListableItem;

class Product extends ListableItem
{
    protected string $id;
    protected string $name;
    protected string $description;
    protected float $price;
    protected int $quantity;
    private int $visibility = 1;

    public function __construct(string $id, string $name,
                                string $description, float $price, int $quantity)
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

    public function __toString(): string
    {
        return "[{$this->id()}]|  {$this->name()}: {$this->description()}|  &dollar;{$this->price()}|   Qty: {$this->quantity()}| ";
    }
}
