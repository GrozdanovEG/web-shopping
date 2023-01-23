<?php

namespace WebShoppingApp\Model;

use WebShoppingApp\DataFlow\InputData;
use WebShoppingApp\DataFlow\InputField;

class ProductFactory
{
    //public function __construct() {}
    /** @param InputField[]
     *  @return Product
     */
    public static function createFromInputData(InputData $inputData): Product
    {
        /** @var $idArr = InputField[] */
        $idArr = $inputData->getInputs();
        $id = isset($idArr['id']) ? $idArr['id']->value(): uniqid('ProdNu', true);
        $name = isset($idArr['name']) ? $idArr['name']->value(): '';
        $description = isset($idArr['description']) ? $idArr['description']->value(): '';
        $price = (float)(isset($idArr['price']) ? $idArr['price']->value(): 0.0);
        $quantity = (int)(isset($idArr['quantity']) ? $idArr['quantity']->value(): 0);
        return new Product($id, $name, $description, $price, $quantity);
    }

}