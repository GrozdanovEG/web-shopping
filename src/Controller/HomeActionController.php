<?php

namespace WebShoppingApp\Controller;

use WebShoppingApp\DataFlow\InputData;
use WebShoppingApp\Model\Product;
use WebShoppingApp\View\PriceListHtmlOutput;

class HomeActionController implements ActionsController
{

    public function canHandle(string $action): bool
    {
        return $action === 'home' || $action === '';
    }

    public function handle(InputData $inputData): array
    {
        $productsFromPriceList = (new FetchProductsFromPriceListController())->handle($inputData) ?? [];
        /* @todo to be moved to View layer and separating logic
         * for managing price list and shopping functionality */
        $inputs = $inputData->getInputs();
        $mode = isset($inputs['mode']) ? $inputs['mode']->value() : '';


            require_once __DIR__ . '/../View/templates/add-product-form.html';
            // @todo To be replaced with HtmlOutput ...
            echo '<table>' . PHP_EOL;
            foreach ($productsFromPriceList as $plp) echo $plp->render();
            echo '</table>' . PHP_EOL;

        return $productsFromPriceList;
    }
}