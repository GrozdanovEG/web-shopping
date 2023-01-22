<?php

namespace WebShoppingApp\Model;

use WebShoppingApp\DataFlow\InputData;

interface ProductStorage
{
    public function store(Product $product, ?InputData $inputData): Product|false;
    public function remove(Product $product): Product|false;
}