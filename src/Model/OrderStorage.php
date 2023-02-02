<?php
declare(strict_types=1);
namespace WebShoppingApp\Model;

use WebShoppingApp\DataFlow\InputData;

interface OrderStorage
{
    public function store(Order $order, ?InputData $inputData): Order|false;
    /** @return Order[] */
    public function fetchAll(): array;

}