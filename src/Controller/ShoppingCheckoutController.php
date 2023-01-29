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
        echo '<div class="message info">Your cart summary. Ready to check out?</div>';
        echo '<table>' . PHP_EOL;
        $total = 0.0;
        foreach ($cartList as $item) {
            $itemTotal = $item->quantity() * $item->price();
            echo <<<ITEM
                <tr>
                    <td>{$item->name()}</td> 
                    <td>{$item->quantity()}</td> 
                    <td>&dollar;{$item->price()}</td>
                    <td>&dollar;{$itemTotal}</td>
                </tr>
            ITEM;
            $total += $itemTotal;
        }
        $finishShopping =<<<FINISH
            <form action="/?" method="post">
                <button type="submit" name="action" name="action" value="finish_checkout">Complete the order</button>
            </form>
        FINISH;
        echo '<tr><td colspan="4">Cart total: &dollar;'.$total.'&nbsp;'.$finishShopping.' </td></tr>';
        echo '</table>' . PHP_EOL;
        return $cartList;
    }
}