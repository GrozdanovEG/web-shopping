<?php

namespace WebShoppingApp\Model;

interface ProductStorage
{
    public function store(Product $product): Product|false;
    public function remove(Product $product): Product|false;
}