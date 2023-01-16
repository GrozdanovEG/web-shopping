<?php
declare(strict_types=1);

namespace WebShoppingApp\Model;
use WebShoppingApp\DataFlow\InputData;

class Cart
{
    private string $orderId;
    private string $productId;
    private int $quantity;
    private float $price;
    private int $visibility = 1;

    public function __construct(string $orderId, string $productId,
                                int $quantity, float $price)
    {
        $this->orderId = $orderId;
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->price = $price;
    }

    public function orderId(): string
    {
        return $this->orderId;
    }

    public function productId(): string
    {
        return $this->productId;
    }

    public function quantity(): int
    {
        return $this->quantity;
    }

    public function price(): float
    {
        return $this->quantity;
    }

    /** @param InputData
     *  @return Cart       */
    public static function createFromInputData(InputData $inputData): self
    {
        $idArr = $inputData->getInputs();
        $orderId = isset($idArr['order_id']) ? $idArr['order_id']->value() : 'invalid order Id';
        $productId = isset($idArr['product_id']) ? $idArr['product_id']->value() : 'invalid product Id';
        $quantity = (int)(isset($idArr['quantity']) ? $idArr['quantity']->value() : 0);
        $price = (float)(isset($idArr['price']) ? $idArr['price']->value() : 0.0);
        return new Cart($orderId, $productId, $quantity, $price);
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