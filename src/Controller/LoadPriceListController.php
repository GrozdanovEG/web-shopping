<?php

namespace WebShoppingApp\Controller;

use WebShoppingApp\DataFlow\InputData;
use WebShoppingApp\View\PriceListHtmlOutput;

class LoadPriceListController implements ActionsController
{

    /**
     * @inheritDoc
     */
    public function canHandle(string $action): bool
    {
        return ($action === 'load_price_list' || $action === '');
    }

    /**
     * @inheritDoc
     */
    public function handle(InputData $inputData): array
    {
        $productsFromPriceList = (new FetchProductsFromPriceListController())->handle($inputData) ?? [];
        echo PHP_EOL . '<form action="/shop.php" method="post">' . PHP_EOL ;
        echo (new PriceListHtmlOutput($productsFromPriceList))->toListView();
        echo '</form>'. PHP_EOL;
        return $productsFromPriceList;
    }
}