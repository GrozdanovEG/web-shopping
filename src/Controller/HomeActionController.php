<?php

namespace WebShoppingApp\Controller;

use WebShoppingApp\DataFlow\InputData;

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
        require_once __DIR__ . '/../View/templates/add-product-form.html';
        echo '<table>' . PHP_EOL;
        foreach ($priceListProducts as $plp)
            echo $plp->render() ;
        echo '</table>' . PHP_EOL;
        return $priceListProducts;
    }
}