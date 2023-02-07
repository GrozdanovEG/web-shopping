<?php
declare(strict_types=1);
namespace WebShoppingApp\Controller;

use WebShoppingApp\DataFlow\InputData;
use WebShoppingApp\Model\Cart;

class ResetCartContentController implements ActionsController
{
    public function canHandle(string $action): bool
    {
        return ($action === 'reset_cart_content' || $action === 'reset_cart');
    }

    public function handle(InputData $inputData): array
    {
        if (! isset($sessionManager)) $sessionManager = new SessionsManager();
        if ( $sessionManager->isRunning() && ($sessionManager->cart) ) {
            $sessionManager->clear(); /* might be removed depending on the business logic */
            $sessionManager->cart = new Cart();
        } else
            $sessionManager->startSafe();

        echo '<div class="message info">You can continue shopping with empty cart now.</div>';
        return [];
    }
}