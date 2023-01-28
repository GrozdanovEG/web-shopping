<?php
declare(strict_types=1);
namespace WebShoppingApp\Controller;

use WebShoppingApp\DataFlow\InputData;
use WebShoppingApp\Model\ProductFactory;
use WebShoppingApp\Model\ProductStorageByPDO;
use WebShoppingApp\Storage\Database;
use WebShoppingApp\Storage\DatabaseData;
use WebShoppingApp\Storage\StorageData;
use WebShoppingApp\Model\Cart;

class ListCartContentController implements ActionsController
{

    public function canHandle(string $action): bool
    {
        return ($action === 'list_cart_content' || $action === 'cart');
    }


    public function handle(InputData $inputData): array
    {
        if (! isset($sessionManager)) $sessionManager = new SessionsManager();
        if ( $sessionManager->isRunning() && (! $sessionManager->cart) ) {
            echo '<div class="message info">Cart is empty or we have an error</div>';
            return [];
        }

        $products = ($sessionManager->cart)->fetchAll();
        /** @todo delegating listing product to external class */
        foreach ($products as $plp) echo $plp. '<br>' . PHP_EOL;
        return [$products];
    }
}