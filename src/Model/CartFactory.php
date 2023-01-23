<?php
declare(strict_types=1);
namespace WebShoppingApp\Model;

//use WebShoppingApp\Model\ProductFactory;
use WebShoppingApp\DataFlow\InputData;

class CartFactory
{
    /** @param InputData
     *  @return Cart       */
    public static function createFromInputData(InputData $inputData): Cart
    {
        //$idArr = $inputData->getInputs();
        $product = ProductFactory::createFromInputData($inputData) ?? null;
        return new Cart($product);
    }


}