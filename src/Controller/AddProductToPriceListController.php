<?php
declare(strict_types=1);
namespace WebShoppingApp\Controller;

//use WebShoppingApp\Controller\ActionsController;
use WebShoppingApp\DataFlow\{InputData,UserInput};
use WebShoppingApp\Storage\{StorageData,DatabaseData};
use WebShoppingApp\Model\ProductFactory;
use WebShoppingApp\Model\ProductStorageByPDO;
use WebShoppingApp\Storage\Database;

class AddProductToPriceListController implements ActionsController
{
    //private Storage $storage;
    public function __construct() //(Storage $storage)
    {
        //$this->storage = $storage;
    }

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
            $productStorage->store($product);
            echo 'A new product stored into the catalog';
        } catch (Exception $ex) {
            echo 'Oooops! Something unexpected happened. Try Again later!';
            echo '<div>{$ex->getMessage()}</div>';
        }
        return [
            'id' => $product->id(),
        ];
    }
}