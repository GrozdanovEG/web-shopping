<?php

declare(strict_types=1);

namespace WebShoppingApp\Controller;

use WebShoppingApp\DataFlow\InputData;
use WebShoppingApp\Storage\{StorageData, DatabaseData};
use WebShoppingApp\Model\ProductFactory;
use WebShoppingApp\Model\ProductStorageByPDO;
use WebShoppingApp\Storage\Database;

class DeleteProductFromPriceListController implements ActionsController
{

    public function __construct() //(Storage $storage)
    {
        //$this->storage = $storage;
    }

    public function canHandle(string $action): bool
    {
        return ($action === 'remove_product');
    }

    public function handle(InputData $inputData): array
    {
        $product = ProductFactory::createFromInputData($inputData);
        $product->hideItem();
        try {
            $databaseData = new DatabaseData((new StorageData())->dbData());
            $productStorage = new ProductStorageByPDO(new Database($databaseData));
            $productStorage->remove($product);
            echo "The product {$product->name()} was removed from the catalog";
        } catch (Exception $ex) {
            echo 'Oooops! Something unexpected happened. Try Again later!';
            echo '<div>{$ex->getMessage()}</div>';
        }
        return [
            'id' => $product->id(),
        ];
    }
}

