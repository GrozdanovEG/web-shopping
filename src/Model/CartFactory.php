<?php

namespace WebShoppingApp\Model;

use WebShoppingApp\DataFlow\InputData;

class CartFactory
{
    /** @param InputData
     *  @return Cart       */
    public static function createFromInputData(InputData $inputData): Cart
    {
        $idArr = $inputData->getInputs();
        $orderId = isset($idArr['order_id']) ? $idArr['order_id']->value() : 'invalid order Id';
        $productId = isset($idArr['product_id']) ? $idArr['product_id']->value() : 'invalid product Id';
        $quantity = (int)(isset($idArr['quantity']) ? $idArr['quantity']->value() : 0);
        $price = (float)(isset($idArr['price']) ? $idArr['price']->value() : 0.0);
        return new Cart($orderId, $productId, $quantity, $price);
    }


}