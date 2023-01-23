<?php
declare(strict_types=1);
namespace WebShoppingApp\Controller;

use WebShoppingApp\DataFlow\InputData;
use WebShoppingApp\Model\ProductFactory;
use WebShoppingApp\Model\ProductStorageByPDO;
use WebShoppingApp\Storage\Database;
use WebShoppingApp\Storage\DatabaseData;
use WebShoppingApp\Storage\StorageData;

class AddProductToCartController implements ActionsController
{

    public function canHandle(string $action): bool
    {
        return ($action === 'add_to_cart');
    }

    public function handle(InputData $inputData): array
    {
        $databaseData = new DatabaseData((new StorageData())->dbData());
        $productStorage = new ProductStorageByPDO(new Database($databaseData));
        $productToUpdateId = $inputData->getInputs()['id']->value();
        $product = $productStorage->findById($productToUpdateId);
        $_SESSION['CART']->addProduct($product);
        //foreach ($priceListProducts as $priceListProduct) echo $priceListProduct . '<br>' . PHP_EOL;


        echo 'Add Product To Cart Controller Invoked: ' . $product;

        return [];
    }
}