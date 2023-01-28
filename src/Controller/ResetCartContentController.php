<?php

namespace WebShoppingApp\Controller;

use WebShoppingApp\DataFlow\InputData;

class ResetCartContentController implements ActionsController
{

    /**
     * @inheritDoc
     */
    public function canHandle(string $action): bool
    {
        return ($action === 'reset_cart_content' || $action === 'reset_cart');
    }

    /**
     * @inheritDoc
     */
    public function handle(InputData $inputData): array
    {
        if (! isset($sessionManager)) $sessionManager = new SessionsManager();
        if ( $sessionManager->isRunning() && ($sessionManager->cart) )
            $sessionManager->clear();
        else
            $sessionManager->startSafe();

        echo '<div class="message info">We can continue shopping with empty cart now.</div>';
        return [];
    }
}