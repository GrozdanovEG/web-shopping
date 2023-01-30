<?php

namespace WebShoppingApp\Model;

use WebShoppingApp\DataFlow\InputData;
use DateTime;

class OrderFactory
{
    /** @param InputData
     *  @return Order       */
    public static function createFromInputData(InputData $inputData): Order
    {
        $idArr = $inputData->getInputs();
        $id = isset($idArr['id']) ? $idArr['id']->value() :
            (new RandomValueGenerator())->mixed(32,36);
        $total = (float)(isset($idArr['total']) ? $idArr['total']->value() : 0.0);
        $completedAd = isset($idArr['completed_at']) ? $idArr['completed_at']->value() : new DateTime('now');
        return new Order($id, $total, $completedAd);
    }

    /** @param Cart
     *  @return Order       */
    public static function createFromCartData(Cart $cart): Order
    {
        $id = (new RandomValueGenerator())->mixed(32,36);
        $total = (float)$cart->total();
        $completedAd = (new DateTime('now'));
        return new Order($id, $total, $completedAd);
    }

}