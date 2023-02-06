<?php
declare(strict_types=1);

namespace WebShoppingApp\Controller;

use WebShoppingApp\DataFlow\InputData;
use WebShoppingApp\Model\ProductStorageByPDO;
use WebShoppingApp\Storage\Database;
use WebShoppingApp\Storage\DatabaseData;
use WebShoppingApp\Storage\StorageData;
use WebShoppingApp\Model\Cart;

class AddProductToCartController implements ActionsController
{

    public function canHandle(string $action): bool
    {
        return ($action === 'add_to_cart');
    }

    public function handle(InputData $inputData): array
    {
        if (! isset($sessionManager)) $sessionManager = new SessionsManager();
        if ( $sessionManager->isRunning() && (! $sessionManager->cart) )
            $sessionManager->cart = new Cart();

        $databaseData = new DatabaseData((new StorageData())->dbData());
        $productStorage = new ProductStorageByPDO(new Database($databaseData));
        $productId = $inputData->getInputs()['id']->value();
        $product = $productStorage->findById($productId);
        $product->clearQuantity();
        $product->incrementQuantity();

        $found = false;
        $cartList = ($sessionManager->cart)->fetchAll();
        $max = count($cartList);
        for ($i = 0; $i < $max; $i++ ) {
            if ($cartList[$i]->id() === $productId) {
                $cartList[$i]->incrementQuantity();
                $found = true;
                break;
            }
        }
        if (! $found) ($sessionManager->cart)->addProduct($product);

        echo "<div class=\"message success\">{$product->name()} added to the cart!</div>";
        return [$product];
    }
}