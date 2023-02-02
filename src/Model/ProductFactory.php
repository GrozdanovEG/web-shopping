<?php

namespace WebShoppingApp\Model;

use WebShoppingApp\DataFlow\InputData;
use WebShoppingApp\DataFlow\InputField;

class ProductFactory
{
    /** @param InputField[]
     *  @return Product
     */
    public static function createFromInputData(InputData $inputData): Product
    {
        /** @var $idArr = InputField[] */
        $idArr = $inputData->getInputs();
        $id = isset($idArr['id']) ? $idArr['id']->value():
                   (new RandomValueGenerator())->mixed(48,52);
        $name = isset($idArr['name']) ? $idArr['name']->value(): '';
        $description = isset($idArr['description']) ? $idArr['description']->value(): '';
        $price = (float)(isset($idArr['price']) ? $idArr['price']->value(): 0.0);
        $quantity = (int)(isset($idArr['quantity']) ? $idArr['quantity']->value(): 0);
        return new Product($id, $name, $description, $price, $quantity);
    }

    public static function createFromArrayAssoc(array $prod): Product
    {
        /** @var  */
        $id = $prod['id'] ?? ($prod['product_id'] ?? (new RandomValueGenerator())->mixed(48, 52));
        $name = $prod['name'] ?? '';
        $description = ($prod['description']) ??  '';
        $price = (float)($prod['price'] ?? 0.0);
        $quantity = (int)($prod['quantity'] ?? 0);
        return new Product($id, $name, $description, $price, $quantity);
    }

}