<?php

namespace WebShoppingApp\Controller;

use WebShoppingApp\DataFlow\InputData;
use WebShoppingApp\Model\Cart;
use WebShoppingApp\Model\OrderFactory;
use WebShoppingApp\Model\OrderStorageByPDO;
use WebShoppingApp\Storage\Database;
use WebShoppingApp\Storage\DatabaseData;
use WebShoppingApp\Storage\StorageData;

class FinishCheckoutController implements ActionsController
{
    public function canHandle(string $action): bool
    {
        return ($action === 'finish_checkout' || $action === 'complete_the_order');
    }

    public function handle(InputData $inputData): array
    {
        if (! isset($sessionManager)) $sessionManager = new SessionsManager();
        if ( $sessionManager->isRunning() && (! $sessionManager->cart) )
            $sessionManager->cart = new Cart();

        $cartList = ($sessionManager->cart)->fetchAll();

        $order = OrderFactory::createFromCartData($sessionManager->cart);

        foreach ($cartList as $cartItem) {
            $order->addItem($cartItem);
        }

        $databaseData = new DatabaseData((new StorageData())->dbData());
        $orderStorage = new OrderStorageByPDO(new Database($databaseData));
        if ($orderStorage->store($order, $inputData)) {
            echo '<div class="message success">The cart was successfully stored in your order list </div>';
            $sessionManager->clear();
        }
        return $cartList;
    }
}