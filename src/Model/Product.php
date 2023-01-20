<?php
declare(strict_types=1);
namespace WebShoppingApp\Model;

use WebShoppingApp\DataFlow\InputField;
use WebShoppingApp\DataFlow\InputData;

class Product
{
    private string $id;
    private string $name;
    private string $description;
    private float $price;
    private int $quantity;
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
}
