<?php
declare(strict_types=1);
namespace WebShoppingApp\Controller;

use WebShoppingApp\DataFlow\InputData;
use WebShoppingApp\View\CartHtmlOutput;

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
            echo '<div class="message info">It seems you cart is empty or there is a problem with processing of your request.</div>';
            return [];
        }
        $products = ($sessionManager->cart)->fetchAll();
        echo  PHP_EOL . '<form method="post" action="/shop.php?" id="cart_form">'.
              PHP_EOL . '<h4>Your Cart Content</h4>' .
              PHP_EOL . (new CartHtmlOutput($products))->toTableView() . PHP_EOL;

        if (count($products) > 0)
        echo <<<EXTRAFIELDS
            <input type="hidden" id="handle_by_id" name="handle_by_id" value="none" />
            <button type="submit" name="action" value="update_cart">Update cart</button>
            <button type="submit" name="action" value="checkout">Proceed to checkout</button>
        EXTRAFIELDS;

        echo '</form>'.PHP_EOL;

        return [$products];
    }
}