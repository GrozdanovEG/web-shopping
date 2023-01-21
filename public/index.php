<?php
declare(strict_types=1);
session_start();

require_once __DIR__ . '/../vendor/autoload.php';
include __DIR__ . '/../src/View/header.html';
include __DIR__ . '/templates/add-product-form.html';


use WebShoppingApp\DataFlow\UserInput;
use WebShoppingApp\DataFlow\InputData;
$userInput = new UserInput();
$inputData = $userInput->getInputs();

echo '<pre>';
//var_dump($userInput);
//exit;


use WebShoppingApp\Controller\AddProductToPriceListController;
if (isset($inputData['action']) && $inputData['action']->value() === 'add_product') {
    (new AddProductToPriceListController())->handle($userInput);
}


echo '</pre>';
echo '<hr>';
include __DIR__ . '/../src/View/footer.html';

