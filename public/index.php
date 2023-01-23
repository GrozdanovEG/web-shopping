<?php
declare(strict_types=1);
session_start();

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/View/templates/header.html';

use WebShoppingApp\DataFlow\UserInput;
use WebShoppingApp\DataFlow\InputData;
$userInput = new UserInput();
$inputData = $userInput->getInputs();

use WebShoppingApp\Controller\ControllerManager;
use WebShoppingApp\Controller\HomeActionController;
use WebShoppingApp\Controller\AddProductToPriceListController;
use WebShoppingApp\Controller\FetchProductsFromPriceListController;
use WebShoppingApp\Controller\UpdateProductFromPriceListController;
use WebShoppingApp\Controller\DeleteProductFromPriceListController;


$controllerManager = new ControllerManager();
$controllerManager
    ->add(new HomeActionController())
    ->add(new AddProductToPriceListController())
    ->add(new UpdateProductFromPriceListController())
    ->add(new DeleteProductFromPriceListController());


$output = $controllerManager->handle($userInput);
//echo '<pre>';var_dump($output);echo '</pre>';




include __DIR__ . '/../src/View/templates/footer.html';

