<?php
declare(strict_types=1);
namespace WebShoppingApp\Model;

use WebShoppingApp\DataFlow\InputData;

interface CartStorage
{
    public function store(Cart $cart, ?InputData $inputData): Cart|false;
}