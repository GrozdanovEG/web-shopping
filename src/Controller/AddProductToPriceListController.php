<?php
declare(strict_types=1);
namespace WebShoppingApp\Controller;

use WebShoppingApp\DataFlow\InputData;
use WebShoppingApp\Storage\{StorageData,DatabaseData};
use WebShoppingApp\Model\ProductFactory;
use WebShoppingApp\Model\ProductStorageByPDO;
use WebShoppingApp\Storage\Database;

class AddProductToPriceListController implements ActionsController
{

    public function canHandle(string $action): bool
    {
        return ($action === 'add_product');
    }

    public function handle(InputData $inputData): array
    {
        $product = ProductFactory::createFromInputData($inputData);
        try {
            $databaseData = new DatabaseData((new StorageData())->dbData());
            $productStorage = new ProductStorageByPDO(new Database($databaseData));
            $productStorage->store($product, $inputData);
            echo '<div class="message success">A new product "'.$product->name().'"stored into the catalog</div>';
        } catch (Exception $ex) {
            echo '<div class="message failure">Oooops! Something unexpected happened. Try Again later!</div>';
            error_log($ex->getMessage());
        }
        return ['id' => $product->id()];
    }
}