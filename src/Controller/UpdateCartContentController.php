<?php
declare(strict_types=1);
namespace WebShoppingApp\Controller;

use WebShoppingApp\DataFlow\InputData;
use WebShoppingApp\Model\Cart;
use WebShoppingApp\Model\Product;

class UpdateCartContentController implements ActionsController
{
    public function canHandle(string $action): bool
    {
        return ($action === 'update_cart' || $action === 'update_cart_content');
    }

    public function handle(InputData $inputData): array
    {
        $priceListProducts = (new FetchProductsFromPriceListController())->handle($inputData) ?? [];
        if (! isset($sessionManager)) $sessionManager = new SessionsManager();
        if ( $sessionManager->isRunning() && (! $sessionManager->cart) )
                $sessionManager->cart = new Cart();

        $cartList = ($sessionManager->cart)->fetchAll();

        $sessionManager->cart = $this->updateCartContent($cartList, $priceListProducts, $inputData);

        echo '<div class="message info">You cart was updated</div>';

        return [$sessionManager->cart->fetchAll()];
    }

    private function updateCartContent(array $cartList, array $priceListProducts,
                                       InputData $inputData): Cart
    {   /* @todo refactoring attempt expected */
        $max = count($cartList);
        $userInputList = $inputData->getInputs();
        $cartUpdated = new Cart();
        for ($i = 0; $i < $max; $i++) {
            $cartProduct = $cartList[$i];
            $userInputQuantity = (int)$userInputList[$cartProduct->id()]?->value();
            $quantity = $userInputQuantity;
            foreach ($priceListProducts as $plp) {
                if ($plp->id() === $cartProduct->id()) {
                    if ($userInputQuantity > $plp->quantity()) {
                        $quantity = $cartProduct->quantity();
                        // @todo moved to separately handled logic
                        echo "<div class='message warning'>Product {$cartProduct->name()} cannot be updated. 
                               No sufficient quantity. 
                              Only {$plp->quantity()} in stock.</div>";
                    } elseif  ($userInputQuantity <= 0) {
                        $quantity = 0;
                    }
                    $productUpdated = new Product($plp->id(), $plp->name(), $plp->description(),
                        $cartProduct->price(), $quantity);
                }
            }
            $cartUpdated->addProduct($productUpdated);
        }
        return $cartUpdated;
    }
}