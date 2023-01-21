<?php
declare(strict_types=1);
session_start();

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/View/templates/header.html';

require_once __DIR__ . '/../src/View/templates/add-product-form.html';

use WebShoppingApp\DataFlow\UserInput;
use WebShoppingApp\DataFlow\InputData;
$userInput = new UserInput();
$inputData = $userInput->getInputs();


use WebShoppingApp\Controller\AddProductToPriceListController;
use WebShoppingApp\Controller\FetchProductsFromPriceListController;
use WebShoppingApp\Controller\UpdateProductFromPriceListController;

if (isset($inputData['action']) && $inputData['action']->value() === 'add_product') {
    (new AddProductToPriceListController())->handle($userInput);
} elseif (isset($inputData['action']) && $inputData['action']->value() === 'update_product') {
    (new UpdateProductFromPriceListController())->handle($userInput);
} else {
    $priceListProducts = (new FetchProductsFromPriceListController())->handle($userInput);
    echo '<table>' . PHP_EOL;
    foreach ($priceListProducts as $plp)
        echo $plp->render() ;
    echo '</table>' . PHP_EOL;
}

echo '<pre>';

echo '</pre>';
echo '<hr>';
include __DIR__ . '/../src/View/templates/footer.html';

