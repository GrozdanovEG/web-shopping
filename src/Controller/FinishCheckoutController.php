<?php

namespace WebShoppingApp\Controller;

use WebShoppingApp\DataFlow\InputData;
use WebShoppingApp\Model\Cart;

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
        echo '<pre>';
        var_dump($cartList);
        echo '</pre>';
        echo '<div class="message info">FinishCheckoutController Invoked!</div>';
        return [];
    }
}