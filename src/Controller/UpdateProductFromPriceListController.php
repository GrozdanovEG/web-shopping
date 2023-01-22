<?php
declare(strict_types=1);
namespace WebShoppingApp\Controller;

use WebShoppingApp\DataFlow\{InputData,UserInput};
use WebShoppingApp\Model\ProductFactory;
use WebShoppingApp\Model\ProductStorageByPDO;
use WebShoppingApp\Storage\Database;
use WebShoppingApp\Storage\DatabaseData;
use WebShoppingApp\Storage\StorageData;

class UpdateProductFromPriceListController implements ActionsController
{
    public function __construct() //(Storage $storage)
    {
        //$this->storage = $storage;
    }

    public function canHandle(string $action): bool
    {
        return ($action === 'update_product');
    }

    public function handle(InputData $inputData): array
    {
        $product = ProductFactory::createFromInputData($inputData);
        try {
            $databaseData = new DatabaseData((new StorageData())->dbData());
            $productStorage = new ProductStorageByPDO(new Database($databaseData));
            $productToUpdateId = $inputData->getInputs()['id']->value();
            $product = $productStorage->findById($productToUpdateId);
            if ($product !== null) {
                echo "<h2>The product {$product->name()} can be/has been modified</h2>";
                require_once __DIR__ . '/../View/templates/update-product-form.php';
            }
            $productStorage->store($product, $inputData);
        } catch (Exception $ex) {
            echo 'Oooops! Something unexpected happened. Try Again later!';
            echo '<div>{$ex->getMessage()}</div>';
        }
        return [
            'id' => $product->id(),
        ];
    }
}
