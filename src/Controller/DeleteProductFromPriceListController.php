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
            echo "<div class=\"message success\">The product {$product->name()} was removed from the catalog</div>";
        } catch (Exception $ex) {
            echo '<div class="message failure">Oooops! Something unexpected happened. Try Again later!</div>';
            error_log($ex->getMessage());
        }
        return ['id' => $product->id()];
    }
}

