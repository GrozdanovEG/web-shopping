<?php

namespace WebShoppingApp\Controller;

use WebShoppingApp\DataFlow\InputData;
use WebShoppingApp\Model\Product;

class HomeActionController implements ActionsController
{

    public function canHandle(string $action): bool
    {
        return $action === 'home' || $action === '';
    }

    public function handle(InputData $inputData): array
    {
        $priceListProducts = (new FetchProductsFromPriceListController())->handle($inputData) ?? [];
        /* @todo to be moved to View layer and separating logic
         * for managing price list and shopping functionality */
        $inputs = $inputData->getInputs();
        $mode = isset($inputs['mode']) ? $inputs['mode']->value() : '';

        if ($mode === 'manage_price_list') {
            require_once __DIR__ . '/../View/templates/add-product-form.html';
            // @todo To be replaced with HtmlOutput ...
            echo '<table>' . PHP_EOL;
            foreach ($priceListProducts as $plp) echo $plp->render();
            echo '</table>' . PHP_EOL;
        } elseif ($mode === 'shopping') {
            echo '<form action="/?mode=shopping" method="post">';
            foreach ($priceListProducts as $plp) {
                $avail = ($plp->quantity() >= 1 ? 'in' : 'out of');
                echo <<<OUTPUT
                    <div>
                        <span class="image"><img src="/media/img/random.png" alt="no image available"></span>
                        <span class="name">{$plp->name()}</span>
                        <span class="description">{$plp->description()}</span>
                        <span class="price">&dollar;{$plp->price()}</span>
                        <span class="availability">{$avail} stock</span>
                        <span class="button">
                            <input type="hidden" name="action" value="add_to_cart">
                            <button type="submit" name="id" value="{$plp->id()}">Add to cart</button>
                        </span>
                    </div>
                OUTPUT;
            }
            echo '</form>';
        }



        return $priceListProducts;
    }
}