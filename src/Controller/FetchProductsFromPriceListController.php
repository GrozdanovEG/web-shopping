<?php

namespace WebShoppingApp\Controller;

use WebShoppingApp\DataFlow\InputData;
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
        $productRecords = [];
        try {
            $databaseData = new DatabaseData((new StorageData())->dbData());
            $productStorage = new ProductStorageByPDO(new Database($databaseData));
            $productRecords = $productStorage->fetchAll();
        } catch (Throwable $th) {
            echo '<div class="message failure"> Oooops! Something unexpected happened. Try Again later!</div>';
            error_log($th->getMessage());
        }
        return $productRecords;
    }
}