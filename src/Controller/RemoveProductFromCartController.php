<?php
declare(strict_types=1);
namespace WebShoppingApp\Controller;

use WebShoppingApp\DataFlow\InputData;
use WebShoppingApp\Model\Cart;
use WebShoppingApp\Model\ProductFactory;

class RemoveProductFromCartController implements ActionsController
{

    public function canHandle(string $action): bool
    {
        return ($action === 'remove_from_cart');
    }

    public function handle(InputData $inputData): array
    {
        if (! isset($sessionManager)) $sessionManager = new SessionsManager();
        if ( $sessionManager->isRunning() && (! $sessionManager->cart) )
            $sessionManager->cart = new Cart();

        $cartList = ($sessionManager->cart)->fetchAll();

        //
        echo '<pre>';
        var_dump($inputData);

        exit;
        $productToRemove = new ProductFactory();
        $cartUpdated = new Cart();
        foreach ($cartList as $item) {
            if ($item->id() === $productToRemove->id()) continue;
            $cartUpdated->addProduct($item);
        }

        $sessionManager->cart = $cartUpdated;
        echo '<div class="message info">Product '.' has been removed from your cart.</div>';
        echo '<div class="message info">RemoveProductFromCartController invoked</div>';
        return[];
    }
}