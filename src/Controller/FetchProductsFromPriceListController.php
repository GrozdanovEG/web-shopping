<?php

namespace WebShoppingApp\Controller;

use WebShoppingApp\DataFlow\InputData;
use WebShoppingApp\Model\ProductFactory;
use WebShoppingApp\Model\ProductStorageByPDO;
use WebShoppingApp\Storage\Database;
use WebShoppingApp\Storage\DatabaseData;
use WebShoppingApp\Storage\StorageData;

class FetchProductsFromPriceListController implements ActionsController
{

    public function __construct() //(Storage $storage)
    {
        //$this->storage = $storage;
    }

    public function canHandle(string $action): bool
    {
        return ($action === 'list_products');
    }

    public function handle(InputData $inputData): array
    {
        try {
            $databaseData = new DatabaseData((new StorageData())->dbData());
            $productStorage = new ProductStorageByPDO(new Database($databaseData));
            return $productStorage->fetchAll();
            echo 'Loading all the products in the price list<br>';
        } catch (Exception $ex) {
            echo 'Oooops! Something unexpected happened. Try Again later!';
            echo '<div>{$ex->getMessage()}</div>';
        }
        return [];
    }
}