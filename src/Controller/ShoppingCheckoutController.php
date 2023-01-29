<?php

namespace WebShoppingApp\Controller;

use WebShoppingApp\DataFlow\InputData;
use WebShoppingApp\Model\Cart;

class ShoppingCheckoutController implements ActionsController
{
    public function canHandle(string $action): bool
    {
        return ($action === 'checkout');
    }

    public function handle(InputData $inputData): array
    {
        if (! isset($sessionManager)) $sessionManager = new SessionsManager();
        if ( $sessionManager->isRunning() && (! $sessionManager->cart) )
            $sessionManager->cart = new Cart();

        $cartList = ($sessionManager->cart)->fetchAll();
        // @todo extacting Cart data and preparing necessary storage calls
        echo '<pre>';
        var_dump($cartList);
        echo '</pre>';

        echo '<div class="message info">Checkout Controller invoked</div>';
        return [];
    }
}