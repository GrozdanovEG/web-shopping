<?php
declare(strict_types=1);
namespace WebShoppingApp\Controller;

use WebShoppingApp\DataFlow\InputData;
use WebShoppingApp\View\CartHtmlOutput;
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
            echo '<div class="message info">Cart is empty or there is an error with processing of your request.</div>';
            return [];
        }
        $products = ($sessionManager->cart)->fetchAll();
        echo '<form mathod="post">' . (new CartHtmlOutput($products))->toTableView();
        echo '<button type="submit" name="action" value="update_cart">Update cart</button>'.PHP_EOL;
        echo '<button type="submit" name="action" value="checkout">Proceed to checkout</button>'.PHP_EOL;
        echo '</form>';
        return [$products];
    }
}